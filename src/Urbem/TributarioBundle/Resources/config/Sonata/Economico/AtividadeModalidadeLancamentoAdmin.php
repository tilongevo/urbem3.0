<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use DateTime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador;
use Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento;
use Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda;
use Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico;
use Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento;
use Urbem\CoreBundle\Entity\Monetario\Moeda;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class AtividadeModalidadeLancamentoAdmin extends AbstractSonataAdmin
{
    const TIPO_VALOR_PERCENTUAL = 'percentual';
    const TIPO_VALOR_MOEDA = 'moeda';
    const TIPO_VALOR_INDICADOR_ECONOMICO = 'indicador_economico';
    const TIPO_VALORES = [
        self::TIPO_VALOR_PERCENTUAL => 'Percentual',
        self::TIPO_VALOR_MOEDA => 'Moeda',
        self::TIPO_VALOR_INDICADOR_ECONOMICO => 'Indicador Econômico',
    ];

    protected $baseRouteName = 'urbem_tributario_economico_modalidade_lancamento_atividade';
    protected $baseRoutePattern = 'tributario/cadastro-economico/modalidade-lancamento/atividade';
    protected $includeJs = ['/tributario/javascripts/economico/modalidade-lancamento.js'];
    protected $exibirBotaoEditar = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qb->andWhere(sprintf('%s.dtBaixa IS NULL', $qb->getRootAlias()));

        return $qb;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->remove('edit');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $atividadeModalidadeLancamento = $em->getRepository(AtividadeModalidadeLancamento::class)
            ->findOneBy(
                [
                    'codAtividade' => $this->getForm()->get('atividade')->getData()->getCodAtividade(),
                    'codModalidade' => $this->getForm()->get('fkEconomicoModalidadeLancamento')->getData()->getCodModalidade(),
                    'dtInicio' => $this->getForm()->get('dtInicio')->getData(),
                ]
            );

        if ($atividadeModalidadeLancamento) {
            $error = $this->getTranslator()->trans('label.economicoAtividadeModalidadeLancamento.erro');
            $errorElement->with('atividade')->addViolation($error)->end();
        }
    }

    /**
     * @param AtividadeModalidadeLancamento|null $object
     */
    public function prePersist($object)
    {
        $this->populateObject($object);
    }

    /**
     * @param AtividadeModalidadeLancamento|null $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkEconomicoAtividade',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.economicoAtividadeModalidadeLancamento.atividade',
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters'],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        $qb = $datagrid->getQuery();
                        $qb->andWhere(sprintf('LOWER(%s.codEstrutural) LIKE :term', $qb->getRootAlias()));
                        $qb->orWhere(sprintf('LOWER(%s.nomAtividade) LIKE :term', $qb->getRootAlias()));
                        $qb->setParameter('term', sprintf('%%%s%%', $value));

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'placeholder' => $this->trans('label.selecione'),
                    'property' => 'codAtividade'
                ],
                [
                    'admin_code' => 'tributario.admin.economico_atividade',
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkEconomicoAtividade.codEstrutural',
                null,
                [
                    'label' => 'label.economicoAtividadeModalidadeLancamento.codigo',
                ]
            )
            ->add(
                'fkEconomicoAtividade.nomAtividade',
                null,
                [
                    'label' => 'label.economicoAtividadeModalidadeLancamento.atividade',
                ]
            )
            ->add(
                'fkEconomicoModalidadeLancamento.nomModalidade',
                null,
                [
                    'label' => 'label.economicoAtividadeModalidadeLancamento.modalidade',
                ]
            )
            ->add(
                'dtInicio',
                null,
                [
                    'template' => 'TributarioBundle::Economico/ModalidadeLancamento/list_atividade_vigencia.html.twig',
                    'label' => 'label.economicoAtividadeModalidadeLancamento.vigencia'
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                        'baixar' => ['template' => 'TributarioBundle:Economico/ModalidadeLancamento:list__action_baixar_atividade.html.twig'],
                        'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                    ],
                    'header_style' => 'width: 35%'
                ]
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['atividade'] = [
            'class' => Atividade::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('LOWER(o.codEstrutural) LIKE :term');
                $qb->orWhere('LOWER(o.nomAtividade) LIKE :term');
                $qb->setParameter('term', sprintf('%%%s%%', $term));

                $qb->addOrderBy('o.codEstrutural', 'ASC');
                $qb->addOrderBy('o.nomAtividade', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (Atividade $atividade) {
                return (string) sprintf('%s - %s', $atividade->getCodEstrutural(), $atividade->getNomAtividade());
            },
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.economicoAtividadeCadastroEconomico.atividade',
        ];

        $fieldOptions['dtInicio'] = [
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.economicoAtividadeModalidadeLancamento.dtInicio',
        ];

        $fieldOptions['fkEconomicoModalidadeLancamento'] = [
            'class' => ModalidadeLancamento::class,
            'choice_value' => 'codModalidade',
            'choice_label' => 'nomModalidade',
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.economicoAtividadeModalidadeLancamento.modalidade',
        ];

        $fieldOptions['tipoValor'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPO_VALORES),
            'expanded' => true,
            'multiple' => false,
            'data' => $this::TIPO_VALOR_PERCENTUAL,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata js-tipo-valor ',
            ],
            'label' => 'label.economicoAtividadeModalidadeLancamento.tipoValor',
        ];

        $fieldOptions['valor'] = [
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ],
            'label' => 'label.economicoAtividadeModalidadeLancamento.valor',
        ];

        $fieldOptions['moeda'] = [
            'class' => Moeda::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-moeda ',
            ],
            'label' => 'label.economicoAtividadeModalidadeLancamento.moeda',
        ];

        $fieldOptions['indicadorEconomico'] = [
            'class' => IndicadorEconomico::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-indicador-economico '
            ],
            'label' => 'label.economicoAtividadeModalidadeLancamento.indicadorEconomico',
        ];

        $formMapper
            ->with('label.economicoAtividadeModalidadeLancamento.cabecalhoModalidadeLancamento')
                ->add(
                    'atividade',
                    'autocomplete',
                    $fieldOptions['atividade'],
                    [
                        'admin_code' => 'tributario.admin.economico_atividade'
                    ]
                )
                ->add('dtInicio', 'datepkpicker', $fieldOptions['dtInicio'])
                ->add('fkEconomicoModalidadeLancamento', 'entity', $fieldOptions['fkEconomicoModalidadeLancamento'])
                ->add('tipoValor', 'choice', $fieldOptions['tipoValor'])
                ->add('valor', 'money', $fieldOptions['valor'])
                ->add('moeda', 'entity', $fieldOptions['moeda'])
                ->add('indicadorEconomico', 'entity', $fieldOptions['indicadorEconomico'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->object = $this->getSubject();

        $showMapper
            ->with('label.economicoAtividadeModalidadeLancamento.modulo')
                ->add(
                    'fkEconomicoAtividade.codEstrutural',
                    null,
                    [
                        'label' => 'label.economicoAtividadeModalidadeLancamento.codigo',
                    ]
                )
                ->add(
                    'fkEconomicoAtividade.nomAtividade',
                    null,
                    [
                        'label' => 'label.economicoAtividadeModalidadeLancamento.atividade',
                    ]
                )
                ->add(
                    'fkEconomicoModalidadeLancamento.nomModalidade',
                    null,
                    [
                        'label' => 'label.economicoAtividadeModalidadeLancamento.modalidade',
                    ],
                    'text',
                    [
                        'choice_value' => 'codModalidade',
                        'choice_label' => 'nomModalidade',
                    ]
                );

        if ($this->object->getPercentual()) {
            $this->tipoValor = $this::TIPO_VALORES[$this::TIPO_VALOR_PERCENTUAL];
        }

        if ($this->object->getFkEconomicoAtividadeModalidadeMoedas()->count()) {
            $this->tipoValor = $this::TIPO_VALORES[$this::TIPO_VALOR_MOEDA];
        }

        if ($this->object->getFkEconomicoAtividadeModalidadeIndicadores()->count()) {
            $this->tipoValor = $this::TIPO_VALORES[$this::TIPO_VALOR_INDICADOR_ECONOMICO];
        }

        $fieldOptions['tipoValor'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/ModalidadeLancamento/atividade_modalidade_lancamento_show.html.twig',
        ];

        $showMapper
                ->add('tipoValor', 'customField', $fieldOptions['tipoValor'])
            ->end();
    }

    /**
    * @param AtividadeModalidadeLancamento $object
    */
    protected function populateObject(AtividadeModalidadeLancamento $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $object->setPercentual(false);
        $object->setDtInicio($form->get('dtInicio')->getData());
        $object->setValor($form->get('valor')->getData());
        $object->setFkEconomicoAtividade($form->get('atividade')->getData());
        $object->setFkEconomicoModalidadeLancamento($form->get('fkEconomicoModalidadeLancamento')->getData());

        $tipoValor = $form->get('tipoValor')->getData();
        if ($tipoValor == $this::TIPO_VALOR_PERCENTUAL) {
            $object->setPercentual(true);
        }

        if ($tipoValor == $this::TIPO_VALOR_MOEDA) {
            $atividadeModalidadeMoeda = new AtividadeModalidadeMoeda();
            $atividadeModalidadeMoeda->setFkMonetarioMoeda($form->get('moeda')->getData());
            $atividadeModalidadeMoeda->setFkEconomicoAtividadeModalidadeLancamento($object);

            $object->addFkEconomicoAtividadeModalidadeMoedas($atividadeModalidadeMoeda);
        }

        if ($tipoValor == $this::TIPO_VALOR_INDICADOR_ECONOMICO) {
            $atividadeModalidadeIndicador = new AtividadeModalidadeIndicador();
            $atividadeModalidadeIndicador->setFkMonetarioIndicadorEconomico($form->get('indicadorEconomico')->getData());
            $atividadeModalidadeIndicador->setFkEconomicoAtividadeModalidadeLancamento($object);

            $object->addFkEconomicoAtividadeModalidadeIndicadores($atividadeModalidadeIndicador);
        }
    }
}
