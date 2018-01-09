<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Frota\Autorizacao;
use Urbem\CoreBundle\Entity\Frota\Posto;
use Urbem\CoreBundle\Entity\Frota\TipoItem;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Patrimonial\Frota\AutorizacaoModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;

/**
 * Class AutorizacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class AutorizacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_autorizacao';
    protected $baseRoutePattern = 'patrimonial/frota/autorizacao';
    protected $model = Model\Patrimonial\Frota\AutorizacaoModel::class;

    protected $includeJs = [
        '/patrimonial/javascripts/frota/autorizacao.js'
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('gera_relatorio', 'gera-relatorio');
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq('o.exercicio', ':exercicio')
        );
        $query->setParameter('exercicio', $this->getExercicio());

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codAutorizacao',
                null,
                [
                    'label' => 'label.autorizacao.codAutorizacao'
                ]
            )
            ->add(
                'fkFrotaVeiculo',
                null,
                [
                    'label' => 'label.autorizacao.veiculo'
                ],
                'entity',
                [
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codAutorizacao',
                'string',
                [
                    'label' => 'label.autorizacao.codAutorizacao',
                    'sortable' => false
                ]
            )
            ->add(
                'fkFrotaVeiculo',
                'text',
                [
                    'label' => 'label.autorizacao.veiculo',
                ]
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        if ($this->id($this->getSubject())) {
            $dtAutorizacao = $this->getSubject()->getTimestamp();

            $quant = (int) $this->getSubject()->getQuantidade();

            if (empty($quant)) {
                $valorUnitario = 0;
                $completarTanque = 'S';
            } else {
                $valorUnitario = $this->getSubject()->getValor() / $this->getSubject()->getQuantidade();
                $completarTanque = 'N';
            }
        } else {
            $completarTanque = 'S';
            $valorUnitario = 0;
            $dtAutorizacao = new DateTimeMicrosecondPK(date('Y-m-d'));
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['timestamp'] = array(
            'format' => 'dd/MM/yyyy',
            'label' => 'label.autorizacao.dtAutorizacao',
            'data' => $dtAutorizacao,
            'mapped' => false
        );

        $fieldOptions['completarTanque'] = array(
            'mapped' => false,
            'choices' => [
                'Sim' => 'S',
                'Não' => 'N',
            ],
            'data' => $completarTanque,
            'multiple' => false,
            'expanded' => true,
            'label' => 'label.autorizacao._completarTanque',
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        );

        $fieldOptions['viasPagina'] = array(
            'mapped' => false,
            'choices' => [
                'Uma' => '1',
                'Duas' => '2',
            ],
            'multiple' => false,
            'expanded' => true,
            'label' => 'label.autorizacao.viasPagina',
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        );

        $fieldOptions['placa'] = array(
            'mapped' => false,
            'label' => 'label.veiculo.placa',
            'required' => false,
            'attr' => [
                'maxlength' => 7,
                'readonly' => 'readonly'
            ]
        );

        $fieldOptions['prefixo'] = array(
            'mapped' => false,
            'label' => 'label.veiculo.prefixo',
            'required' => false,
            'attr' => [
                'readonly' => 'readonly',
            ]
        );

        $formMapper
            ->with('label.autorizacao.tituloAutorizacao')
                ->add(
                    'fkFrotaVeiculo',
                    'entity',
                    [
                        'class' => 'CoreBundle:Frota\Veiculo',
                        'label' => 'label.autorizacao.veiculo',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                        'placeholder' => 'label.selecione'
                    ]
                )
            ->end()
            ->add(
                'placa',
                'text',
                $fieldOptions['placa']
            )
            ->add(
                'prefixo',
                'text',
                $fieldOptions['prefixo']
            )
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                [
                    'property' => 'nomCgm',
                    'placeholder' => $this->trans('label.selecione'),
                    'label' => 'label.autorizacao.responsavel'
                ],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm'
                ]
            )
            ->add(
                'fkSwCgm1',
                'sonata_type_model_autocomplete',
                [
                    'property' => 'nomCgm',
                    'callback' => function (AbstractAdmin $admin, $property, $value) use ($entityManager) {
                        $datagrid = $admin->getDatagrid();
                        $subquery = $entityManager->createQueryBuilder();
                        $subquery
                            ->select('posto.cgmPosto')
                            ->from(Posto::class, 'posto');

                        /** @var \Doctrine\ORM\QueryBuilder $query */
                        $query = $datagrid->getQuery();

                        $swCgmModel = new SwCgmModel($entityManager);
                        $swCgmModel->recuperaApenasPessoasFisicasEJuridicas($query)
                            ->andWhere(
                                $query->expr()->in("{$query->getRootAlias()}.numcgm", $subquery->getDQL())
                            );

                        $datagrid->setValue($property, null, $value);
                    },
                    'placeholder' => $this->trans('label.selecione'),
                    'label' => 'label.autorizacao.fornecedor'
                ],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm'
                ]
            )
            ->add(
                'fkSwCgm2',
                'sonata_type_model_autocomplete',
                [
                    'callback' => function (AbstractAdmin $admin, $property, $value) use ($entityManager) {
                        $datagrid = $admin->getDatagrid();

                        /** @var \Doctrine\ORM\QueryBuilder $query */
                        $query = $datagrid->getQuery();
                        $rootAlias = $query->getRootAlias();

                        $query
                            ->join("{$rootAlias}.fkFrotaMotorista", "motorista")
                            ->andWhere("motorista.ativo = true")
                        ;

                        $datagrid->setValue($property, null, $value);
                    },
                    'property' => 'nomCgm',
                    'placeholder' => $this->trans('label.selecione'),
                    'label' => 'label.autorizacao.motorista'
                ],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm'
                ]
            )
            ->add(
                'dtAutorizacao',
                'sonata_type_date_picker',
                $fieldOptions['timestamp']
            )
            ->add(
                'completarTanque',
                'choice',
                $fieldOptions['completarTanque']
            )
            ->add(
                'fkFrotaItem',
                'entity',
                [
                    'class' => 'CoreBundle:Frota\Item',
                    'label' => 'label.autorizacao.combustivel',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'placeholder' => 'label.selecione',
                    'query_builder' => function (EntityRepository $em) {
                        $queryBuilder = $em->createQueryBuilder('item');
                        $queryBuilder
                            ->where('item.codTipo = '.TipoItem::TIPO_COMBUSTIVEL)
                        ;

                        return $queryBuilder;
                    }
                ],
                [
                    'admin_code' => 'patrimonial.admin.item'
                ]
            )
            ->add(
                'quantidade',
                'number',
                [
                    'label' => 'label.autorizacao.quantidade',
                    'attr' => [
                        'class' => 'quantity '
                    ]
                ]
            )
            ->add(
                'valorUnitario',
                'money',
                [
                    'label' => 'label.autorizacao.valorUnitario',
                    'grouping' => false,
                    'currency' => 'BRL',
                    'attr' => array(
                        'class' => 'money '
                    ),
                    'data' => $valorUnitario,
                    'mapped' => false
                ]
            )
            ->add(
                'valor',
                'money',
                [
                    'label' => 'label.autorizacao.valor',
                    'grouping' => false,
                    'currency' => 'BRL',
                    'attr' => array(
                        'class' => 'money '
                    ),
                ]
            )
            ->add(
                'observacao',
                'textarea',
                [
                    'label' => 'label.autorizacao.observacao',
                    'required' => false
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $fieldOptions['dadosVeiculo'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle::Frota/Autorizacao/reemitir.html.twig',
            'data' => array(
                'veiculo' => $this->getSubject()
            )
        );

        $showMapper
            ->with('label.autorizacao.autorizacao')
            ->add(
                'codAutorizacao',
                null,
                [
                    'label' => 'label.autorizacao.autorizacao'
                ]
            )
            ->add(
                'exercicio',
                null,
                [
                    'label' => 'label.autorizacao.exercicio'
                ]
            )
            ->add(
                'quantidade',
                null,
                [
                    'label' => 'label.autorizacao.quantidade'
                ]
            )
            ->add(
                'valor',
                null,
                [
                    'label' => 'label.autorizacao.valor'
                ]
            )
            ->add(
                'observacao',
                null,
                [
                    'label' => 'label.autorizacao.observacao'
                ]
            )
            ->add(
                'fkSwCgm2',
                null,
                [
                    'label' => 'label.autorizacao.motorista'
                ]
            )
            ->add(
                'fkSwCgm1',
                null,
                [
                    'label' => 'label.autorizacao.fornecedor'
                ]
            )
            ->add(
                'fkSwCgm',
                null,
                [
                    'label' => 'label.autorizacao.autorizacao'
                ]
            )
            ->add(
                'fkFrotaVeiculo',
                'text',
                [
                    'label' => 'label.autorizacao.veiculo'
                ]
            )
            ->add(
                'fkFrotaItem',
                'text',
                [
                    'label' => 'label.autorizacao.combustivel',
                    'admin_code' => 'patrimonial.admin.item'
                ]
            )
            ->end()
            ->with('label.autorizacao.reemitir')
            ->add(
                'dadosVeiculo',
                'customField',
                $fieldOptions['dadosVeiculo']
            )
            ->end();
    }

    /**
     * @param Autorizacao $autorizacao
     */
    public function prePersist($autorizacao)
    {
        $timeStamp = $this->getForm()->get('dtAutorizacao')->getData();

        $dtAutorizacao = new DateTimeMicrosecondPK($timeStamp->format('Y-m-d'));

        $autorizacao->setTimestamp($dtAutorizacao);
        $autorizacao->setExercicio($this->getExercicio());

        $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Autorizacao');
        $autorizacaoModel = new AutorizacaoModel($em);

        $codAutorizacao = $autorizacaoModel->getAvailableIdentifier($this->getExercicio());

        $autorizacao->setCodAutorizacao($codAutorizacao);
    }

    public function preUpdate($autorizacao)
    {
        $timeStamp = $this->getForm()->get('dtAutorizacao')->getData();

        $dtAutorizacao = new DateTimeMicrosecondPK($timeStamp->format('Y-m-d'));
        $autorizacao->setTimestamp($dtAutorizacao);
    }

    /**
     * @param mixed $object
     */
    public function redirect($object)
    {
        $this->forceRedirect("/patrimonial/frota/autorizacao/{$this->getObjectKey($object)}/show");
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $this->redirect($object);
    }

    /**
     * @param mixed $object
     */
    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    /**
     * @param ErrorElement $errorElement
     * @param Autorizacao $autorizacao
     */
    public function validate(ErrorElement $errorElement, $autorizacao)
    {
        if ($this->getForm()->get('completarTanque')->getData() == 'N') {
            if (is_null($autorizacao->getFkFrotaVeiculo()->getCapacidadeTanque()) || $autorizacao->getFkFrotaVeiculo()->getCapacidadeTanque() < $this->getForm()->get('quantidade')->getData()) {
                $message = $this->trans('frota.autorizacao.quantidadeCombustivelMaiorQueCapacidade', ['capacidadeCobustivel' => $autorizacao->getFkFrotaVeiculo()->getCapacidadeTanque()], 'validators');
                $errorElement->with('quantidade')->addViolation($message)->end();
            }
        }

        if (strtotime($this->getForm()->get('dtAutorizacao')->getData()->format('d/m/Y')) > strtotime(date('d/m/Y'))) {
            $message = $this->trans('frota.autorizacao.msgDataAutorizacao', [], 'validators');
            $errorElement->with('dtAutorizacao')->addViolation($message)->end();
        }

        if ($this->getForm()->get('dtAutorizacao')->getData()->format('Y') != $this->getExercicio()) {
            $message = $this->trans('frota.autorizacao.msgDataExercicioAtual', [], 'validators');
            $errorElement->with('dtAutorizacao')->addViolation($message)->end();
        }
    }
}
