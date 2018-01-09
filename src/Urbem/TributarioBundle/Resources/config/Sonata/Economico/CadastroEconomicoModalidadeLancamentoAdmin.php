<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use DateTime;
use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento;
use Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador;
use Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda;
use Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento;
use Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon;
use Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico;
use Urbem\CoreBundle\Entity\Monetario\Moeda;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CadastroEconomicoModalidadeLancamentoAdmin extends AbstractSonataAdmin
{
    const TIPO_VALOR_PERCENTUAL = 'percentual';
    const TIPO_VALOR_MOEDA = 'moeda';
    const TIPO_VALOR_INDICADOR_ECONOMICO = 'indicador_economico';
    const TIPO_VALORES = [
        self::TIPO_VALOR_PERCENTUAL => 'Percentual',
        self::TIPO_VALOR_MOEDA => 'Moeda',
        self::TIPO_VALOR_INDICADOR_ECONOMICO => 'Indicador Econômico',
    ];

    protected $baseRouteName = 'urbem_tributario_economico_modalidade_lancamento_cadastro_economico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/modalidade-lancamento/inscricao-economica';
    protected $includeJs = ['/tributario/javascripts/economico/modalidade-lancamento.js'];
    protected $exibirBotaoEditar = false;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->remove('edit');
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qb->join('o.fkEconomicoAtividadeCadastroEconomicos', 'ace');
        $qb->join('ace.fkEconomicoCadastroEconomicoModalidadeLancamentos', 'ceml');

        $qb->andWhere('ceml.dtBaixa IS NULL');

        return $qb;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $cadastroEconomicoModalidadeLancamento = $em->getRepository(CadastroEconomicoModalidadeLancamento::class)
            ->findOneBy(
                [
                    'inscricaoEconomica' => $this->getForm()->get('cadastroEconomico')->getData()->getInscricaoEconomica(),
                ]
            );

        if ($cadastroEconomicoModalidadeLancamento) {
            $error = $this->getTranslator()->trans('label.economicoCadastroEconomicoModalidadeLancamento.erro');
            $errorElement->with('fkEconomicoAtividadeCadastroEconomico__inscricaoEconomica')->addViolation($error)->end();
        }
    }

    /**
     * @param CadastroEconomicoModalidadeLancamento|null $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        $em->getConnection()->beginTransaction();

        try {
            $this->populateObject($object, $em);
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans('label.economicoCadastroEconomicoModalidadeLancamento.msgSucesso')
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
        } finally {
            return $this->forceRedirect($this->generateObjectUrl('list', $object));
        }
    }

    /**
     * @param CadastroEconomicoModalidadeLancamento|null $object
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $modalidadeLancamentos = $em->getRepository(CadastroEconomicoModalidadeLancamento::class)
            ->findBy(
                [
                    'inscricaoEconomica' => $object->getInscricaoEconomica(),
                ]
            );

        foreach ($modalidadeLancamentos as $modalidadeLancamento) {
            $em->remove($modalidadeLancamento);
        }

        $em->flush();

        return $this->forceRedirect($this->generateUrl('list'));
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->andWhere(sprintf('%s.inscricaoEconomica = :inscricaoEconomica', $qb->getRootAlias()));
        $qb->setParameter('inscricaoEconomica', $value['value']->getInscricaoEconomica());

        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('inscricaoEconomica', null, ['label' => 'label.economicoCadastroEconomicoModalidadeLancamento.inscricaoEconomica'])
            ->add(
                'fkEconomicoCadastroEconomico',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getSearchFilter'],
                    'label' => 'label.economicoCadastroEconomicoAutonomo.cgm',
                ],
                'entity',
                [
                    'class' => CadastroEconomico::class,
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');

                        $qb->join('o.fkEconomicoAtividadeCadastroEconomicos', 'ace');
                        $qb->join('ace.fkEconomicoCadastroEconomicoModalidadeLancamentos', 'ceml');

                        $qb->andWhere('ceml.dtBaixa IS NULL');

                        return $qb;
                    },
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
                'fkEconomicoAtividadeCadastroEconomico.inscricaoEconomica',
                null,
                [
                    'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.inscricaoEconomica',
                ]
            )
            ->add(
                'nomCgm',
                null,
                [
                    'template'=>'TributarioBundle::Economico/ModalidadeLancamento/list_nom_cgm.html.twig',
                    'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.nome',
                ]
            )
            ->add(
                'dtInicio',
                null,
                [
                    'template'=>'TributarioBundle::Economico/ModalidadeLancamento/list_cadastro_economico_vigencia.html.twig',
                    'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.vigencia'
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                        'baixar' => ['template' => 'TributarioBundle:Economico/ModalidadeLancamento:list__action_baixar_cadastro_economico.html.twig'],
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
        $fieldOptions['cadastroEconomico'] = [
            'class' => CadastroEconomico::class,
            'mapped' => false,
            'required' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->innerJoin(sprintf('%s.fkEconomicoAtividadeCadastroEconomicos', $qb->getRootAlias()), 'ace');
                $qb->leftJoin(sprintf('%s.fkEconomicoCadastroEconomicoEmpresaFato', $qb->getRootAlias()), 'ef');
                $qb->leftJoin(sprintf('%s.fkEconomicoCadastroEconomicoEmpresaDireito', $qb->getRootAlias()), 'ed');
                $qb->leftJoin(sprintf('%s.fkEconomicoCadastroEconomicoAutonomo', $qb->getRootAlias()), 'a');
                $qb->leftJoin('ef.fkSwCgmPessoaFisica', 'efpf');
                $qb->leftJoin('ed.fkSwCgmPessoaJuridica', 'edpj');
                $qb->leftJoin('a.fkSwCgmPessoaFisica', 'apf');

                $qb->leftJoin('efpf.fkSwCgm', 'efcgm');
                $qb->leftJoin('edpj.fkSwCgm', 'edcgm');
                $qb->leftJoin('apf.fkSwCgm', 'acgm');

                $qb->andWhere('LOWER(efcgm.nomCgm) LIKE :term');
                $qb->orWhere('LOWER(edcgm.nomCgm) LIKE :term');
                $qb->orWhere('LOWER(acgm.nomCgm) LIKE :term');
                $qb->setParameter('term', sprintf('%%%s%%', $term));

                return $qb;
            },
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.inscricaoEconomica',
        ];

        $fieldOptions['fkEconomicoAtividadeCadastroEconomico'] = [
            'class' => Atividade::class,
            'mapped' => false,
            'required' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->innerJoin('o.fkEconomicoAtividadeCadastroEconomicos', 'ace');

                if (!$request->get('inscricaoEconomica')) {
                    $qb->andWhere('1 = 2');
                }

                $qb->andWhere('ace.inscricaoEconomica = :inscricaoEconomica');
                $qb->setParameter('inscricaoEconomica', $request->get('inscricaoEconomica'));

                $qb->andWhere('LOWER(o.nomAtividade) LIKE :term');
                $qb->setParameter('term', sprintf('%%%s%%', $term));

                $qb->addOrderBy('o.codEstrutural', 'ASC');
                $qb->addOrderBy('o.nomAtividade', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (Atividade $atividade) {
                return (string) sprintf('%s - %s', $atividade->getCodEstrutural(), $atividade->getNomAtividade());
            },
            'req_params' => [
                'inscricaoEconomica' => 'varJsInscricaoEconomica',
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.atividade',
        ];

        $fieldOptions['dtInicio'] = [
            'pk_class' => DatePK::class,
            'mapped' => false,
            'required' => false,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.dtInicio',
        ];

        $fieldOptions['fkEconomicoModalidadeLancamento'] = [
            'class' => ModalidadeLancamento::class,
            'mapped' => false,
            'required' => false,
            'choice_value' => 'codModalidade',
            'choice_label' => 'nomModalidade',
            'attr' => [
                'class' => 'select2-parameters js-modalidade-lancamento ',
            ],
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.modalidade',
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
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.tipoValor',
        ];

        $fieldOptions['valor'] = [
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money js-valor '
            ],
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.valor',
        ];

        $fieldOptions['moeda'] = [
            'class' => Moeda::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-moeda ',
            ],
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.moeda',
        ];

        $fieldOptions['indicadorEconomico'] = [
            'class' => IndicadorEconomico::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-indicador-economico '
            ],
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.indicadorEconomico',
        ];

        $fieldOptions['fkSwClassificacao'] = [
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-processo-classificacao'
            ],
            'label' => 'label.economicoCadastroEconomico.processoClassificacao',
        ];

        $fieldOptions['fkSwAssunto'] = [
            'class' => SwAssunto::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'choice_value' => 'codAssunto',
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-processo-assunto'
            ],
            'label' => 'label.economicoCadastroEconomico.processoAssunto',
        ];

        $fieldOptions['fkSwProcesso'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao')) {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }

                if ($request->get('codAssunto')) {
                    $qb->andWhere('o.codAssunto = :codAssunto');
                    $qb->setParameter('codAssunto', (int) $request->get('codAssunto'));
                }

                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codProcesso', ':codProcesso'),
                    $qb->expr()->eq('cgm.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                $qb->setParameter('codProcesso', (int) $term);
                $qb->orderBy('o.codProcesso', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto'
            ],
            'attr' => [
                'class' => 'select2-parameters js-processo',
            ],
            'label' => 'label.economicoCadastroEconomico.processo',
        ];

        $fieldOptions['incluirAtividade'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/AtividadeCadastroEconomico/incluir_atividade.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaAtividades'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/ModalidadeLancamento/lista_atividades.html.twig',
            'data' => [],
        ];

        $formMapper
            ->with('label.economicoCadastroEconomicoModalidadeLancamento.cabecalhoModalidadeLancamento')
                ->add(
                    'cadastroEconomico',
                    'autocomplete',
                    $fieldOptions['cadastroEconomico'],
                    [
                        'admin_code' => 'tributario.admin.economico_atividade_cadastro_economico',
                    ]
                )
                ->add('dtInicio', 'datepkpicker', $fieldOptions['dtInicio'])
            ->end()
            ->with('label.economicoCadastroEconomicoModalidadeLancamento.cabecalhoProcesso')
                ->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
                ->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto'])
                ->add(
                    'fkSwProcesso',
                    'autocomplete',
                    $fieldOptions['fkSwProcesso'],
                    [
                        'admin_code' => 'administrativo.admin.processo'
                    ]
                )
            ->end()
            ->with('label.economicoCadastroEconomicoModalidadeLancamento.cabecalhoAtividadeEconomica')
                ->add(
                    'fkEconomicoAtividadeCadastroEconomico',
                    'autocomplete',
                    $fieldOptions['fkEconomicoAtividadeCadastroEconomico'],
                    [
                        'admin_code' => 'tributario.admin.economico_atividade_cadastro_economico'
                    ]
                )
                ->add('fkEconomicoModalidadeLancamento', 'entity', $fieldOptions['fkEconomicoModalidadeLancamento'])
                ->add('tipoValor', 'choice', $fieldOptions['tipoValor'])
                ->add('valor', 'money', $fieldOptions['valor'])
                ->add('moeda', 'entity', $fieldOptions['moeda'])
                ->add('indicadorEconomico', 'entity', $fieldOptions['indicadorEconomico'])
                ->add('incluirAtividade', 'customField', $fieldOptions['incluirAtividade'])
            ->end()
            ->with('label.economicoCadastroEconomicoModalidadeLancamento.cabecalhoListaAtividades')
                ->add('listaAtividades', 'customField', $fieldOptions['listaAtividades'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->object = $this->getSubject();
        $this->tipoValor = $this::TIPO_VALORES;

        $fieldOptions['tipoValor'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/ModalidadeLancamento/cadastro_economico_modalidade_lancamento_show.html.twig',
        ];

        $showMapper->add('tipoValor', 'customField', $fieldOptions['tipoValor']);
    }

    /**
    * @param CadastroEconomico $object
    * @param $em
    */
    protected function populateObject(CadastroEconomico $object, $em)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();
        $processo = $form->get('fkSwProcesso')->getData();
        foreach ((array) $this->getRequest()->get('atividades') as $atividade) {
            $modalidadeLancamento = new CadastroEconomicoModalidadeLancamento();
            $modalidadeLancamento->setPercentual(false);

            $valor = str_replace(',', '.', str_replace('.', '', $atividade['valor']));
            $modalidadeLancamento->setValor($valor);

            $dtInicio = (new DateTime())->createFromFormat('d/m/Y', $atividade['dtInicio']);
            $modalidadeLancamento->setDtInicio(new DatePK($dtInicio->format('Y-m-d')));

            $atividadeCadastroEconomico = $em->getRepository(AtividadeCadastroEconomico::class)->findOneBy(
                [
                    'inscricaoEconomica' => $atividade['inscricaoEconomica'],
                    'codAtividade' => $atividade['codAtividade'],
                ]
            );
            $modalidadeLancamento->setFkEconomicoAtividadeCadastroEconomico($atividadeCadastroEconomico);

            $modalidadeLancamento->setFkEconomicoModalidadeLancamento($em->getRepository(ModalidadeLancamento::class)->find($atividade['codModalidade']));

            $tipoValor = $atividade['tipoValor'];
            if ($tipoValor == $this::TIPO_VALOR_PERCENTUAL) {
                $modalidadeLancamento->setPercentual(true);
            }

            if ($tipoValor == $this::TIPO_VALOR_MOEDA) {
                $modalidadeMoeda = new CadEconModalidadeMoeda();
                $modalidadeMoeda->setFkMonetarioMoeda($em->getRepository(Moeda::class)->find($atividade['codIndexador']));
                $modalidadeMoeda->setFkEconomicoCadastroEconomicoModalidadeLancamento($modalidadeLancamento);

                $modalidadeLancamento->addFkEconomicoCadEconModalidadeMoedas($modalidadeMoeda);
            }

            if ($tipoValor == $this::TIPO_VALOR_INDICADOR_ECONOMICO) {
                $modalidadeIndicador = new CadEconModalidadeIndicador();
                $modalidadeIndicador->setFkMonetarioIndicadorEconomico($em->getRepository(IndicadorEconomico::class)->find($atividade['codIndexador']));
                $modalidadeIndicador->setFkEconomicoCadastroEconomicoModalidadeLancamento($modalidadeLancamento);

                $modalidadeLancamento->addFkEconomicoCadEconModalidadeIndicadores($modalidadeIndicador);
            }

            if ($processo) {
                $processoModalidadeLancamento = (new ProcessoModLancInscEcon())->setFkSwProcesso($processo);
                $modalidadeLancamento->addFkEconomicoProcessoModLancInscEcons($processoModalidadeLancamento);
            }

            $em->persist($modalidadeLancamento);
        }
    }
}
