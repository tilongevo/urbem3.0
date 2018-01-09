<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoConvenioModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoEntregaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;
use Urbem\CoreBundle\Model\Administracao\AssinaturaModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Entity\Compras\Entidade;
use Urbem\CoreBundle\Entity\Orcamento;

/**
 * Class SolicitacaoAdmin
 *
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class SolicitacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_solicitacao';
    protected $baseRoutePattern = 'patrimonial/compras/solicitacao';

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'exercicio'
    );

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'anular-solicitacao',
            '{id}/anular-solicitacao'
        );
        $collection->add(
            'homologar_solicitacao',
            '{id}/homologar-solicitacao'
        );
        $collection->add(
            'anular_homologacao_solicitacao',
            '{id}/anular-homologacao-solicitacao'
        );

        $collection->add('gerar_relatorio', '{id}/gerar_relatorio');
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);

        $filters = $this->getRequest()->query->get('filter');

        if (is_null($filters) || empty($filters['exercicio']['value']) || empty($filters['fkOrcamentoEntidade']['value'])) {
            $query->andWhere('1 = 0');
            $this->exibirMensagemFiltro = true;
        }

        return $query;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $joinItensAtivo = false;
        $queryBuilder->resetDQLPart('join');
        if (isset($filter['fkComprasSolicitacaoItens__fkAlmoxarifadoCatalogoItem']['value']) and $filter['fkComprasSolicitacaoItens__fkAlmoxarifadoCatalogoItem']['value'] != '') {
            $queryBuilder->join("o.fkComprasSolicitacaoItens", "item");
            $queryBuilder->andWhere("item.codItem = :fkComprasSolicitacaoItens");
            $queryBuilder->setParameter("fkComprasSolicitacaoItens", $filter['fkComprasSolicitacaoItens__fkAlmoxarifadoCatalogoItem']['value']);
            $joinItensAtivo = true;
        }

        if (isset($filter['fkComprasSolicitacaoItens__fkAlmoxarifadoCentroCusto']['value']) and $filter['fkComprasSolicitacaoItens__fkAlmoxarifadoCentroCusto']['value'] != '') {
            if ($joinItensAtivo == false) {
                $queryBuilder->join("o.fkComprasSolicitacaoItens", "item");
                $joinItensAtivo = true;
            }

            $queryBuilder->andWhere("item.codCentro = :fkAlmoxarifadoCentroCusto");
            $queryBuilder->setParameter("fkAlmoxarifadoCentroCusto", $filter['fkComprasSolicitacaoItens__fkAlmoxarifadoCentroCusto']['value']);
        }

        if (isset($filter['fkComprasSolicitacaoItens__fkComprasSolicitacaoItemDotacoes']['value']) and $filter['fkComprasSolicitacaoItens__fkComprasSolicitacaoItemDotacoes']['value'] != '') {
            if ($joinItensAtivo == false) {
                $queryBuilder->join("o.fkComprasSolicitacaoItens", "item");
                $joinItensAtivo = true;
            }
            $queryBuilder->join("item.fkComprasSolicitacaoItemDotacoes", "despesas");

            $queryBuilder->andWhere("despesas.codDespesa = :codDespesa");
            $queryBuilder->setParameter("codDespesa", $filter['fkComprasSolicitacaoItens__fkComprasSolicitacaoItemDotacoes']['value']);
        }

        if (isset($filter['exercicio']['value']) and $filter['exercicio']['value'] != '') {
            $queryBuilder->andWhere("o.exercicio = :exercicio");
            $queryBuilder->setParameter("exercicio", $filter['exercicio']['value']);
        }

        if (isset($filter['codSolicitacao']['value']) and $filter['codSolicitacao']['value'] != '') {
            $queryBuilder->andWhere("o.codSolicitacao = :codSolicitacao");
            $queryBuilder->setParameter("codSolicitacao", $filter['codSolicitacao']['value']);
        }

        if (isset($filter['fkOrcamentoEntidade']['value']) and $filter['fkOrcamentoEntidade']['value'] != '') {
            $queryBuilder->andWhere("o.codEntidade = :codEntidade");
            $queryBuilder->setParameter("codEntidade", $filter['fkOrcamentoEntidade']['value']);
        }

        if (isset($filter['fkComprasObjeto']['value']) and $filter['fkComprasObjeto']['value'] != '') {
            $queryBuilder->andWhere("o.codObjeto = :codObjeto");
            $queryBuilder->setParameter("codObjeto", $filter['fkComprasObjeto']['value']);
        }

        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add('exercicio', 'doctrine_orm_callback', [
                'callback' => [$this, 'getSearchFilter'],
                'label'    => 'label.patrimonial.compras.solicitacao.exercicio',
            ], null, [
                'attr' => ['required' => true],
            ])
            ->add('fkOrcamentoEntidade', 'doctrine_orm_callback', [
                'callback'   => [$this, 'getSearchFilter'],
                'label'      => 'label.comprasDireta.codEntidade',
                'admin_code' => 'financeiro.admin.entidade',
            ], 'entity', [
                'attr'          => ['class' => 'select2-parameters ', 'required' => true],
                'label'         => 'label.comprasDireta.codEntidade',
                'class'         => Orcamento\Entidade::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($exercicio) {
                    $queryBuilder = $entityRepository->createQueryBuilder('objeto');
                    $queryBuilder
                        ->join('objeto.fkComprasSolicitacoes', 'fkComprasSolicitacoes')
                        ->andWhere('fkComprasSolicitacoes.exercicio = :exercicio')
                        ->setParameter('exercicio', $exercicio);

                    return $queryBuilder;
                },
                'choice_value' => 'codEntidade',
                'placeholder'  => 'label.selecione',
            ])
            ->add('codSolicitacao', 'doctrine_orm_callback', [
                'callback' => [$this, 'getSearchFilter'],
                'label'    => 'label.patrimonial.compras.solicitacao.codSolicitacao',
            ])
            ->add('fkComprasObjeto', 'doctrine_orm_callback', [
                'callback' => [$this, 'getSearchFilter'],
                'label'    => 'label.convenioAdmin.codObjeto',
            ], 'entity', [
                'label'         => 'label.convenioAdmin.codObjeto',
                'class'         => 'CoreBundle:Compras\Objeto',
                'choice_label'  => 'descricao',
                'query_builder' => function (EntityRepository $entityRepository) use ($exercicio) {
                    $queryBuilder = $entityRepository->createQueryBuilder('objeto');
                    $queryBuilder
                        ->join('objeto.fkComprasSolicitacoes', 'fkComprasSolicitacoes')
                        ->andWhere('fkComprasSolicitacoes.exercicio = :exercicio')
                        ->setParameter('exercicio', $exercicio);

                    return $queryBuilder;
                },
                'choice_value'  => 'codObjeto',
            ])
            ->add('fkComprasSolicitacaoItens.fkAlmoxarifadoCatalogoItem', 'doctrine_orm_callback', [
                'label'    => 'label.patrimonial.compras.solicitacao.item',
                'callback' => [$this, 'getSearchFilter'],
            ], 'autocomplete', [
                'class'             => CatalogoItem::class,
                'route'             => [
                    'name' => 'patrimonio_compras_solicitacao_recupera_item',
                ],
                'json_choice_label' => function ($catalogoItem) {
                    return $catalogoItem->getDescricao();
                },
                'mapped'            => true,
            ])
            ->add('fkComprasSolicitacaoItens.fkAlmoxarifadoCentroCusto', 'doctrine_orm_callback', [
                'callback' => [$this, 'getSearchFilter'],
                'label'    => 'label.patrimonial.compras.solicitacao.centrocusto',
            ], 'entity', [
                'label'        => 'label.patrimonial.compras.solicitacao.centrocusto',
                'class'        => 'CoreBundle:Almoxarifado\CentroCusto',
                'choice_label' => 'descricao',
                'choice_value' => 'codCentro',
                'mapped'       => true,
                'placeholder'  => 'label.selecione',
            ])
            ->add('fkComprasSolicitacaoItens.fkComprasSolicitacaoItemDotacoes', 'doctrine_orm_callback', [
                'label'    => 'label.patrimonial.compras.solicitacao.dotacaoorcamentaria',
                'callback' => [$this, 'getSearchFilter'],
            ], 'choice', [
                'choices'     => [],
                'placeholder' => 'label.selecione',
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper

            ->add(
                'codSolicitacaoExercicio',
                null,
                [
                    'label' => 'label.patrimonial.compras.solicitacao.codSolicitacao',
                    'sortable' => false
                ]
            )
            ->add(
                'fkOrcamentoEntidade.fkSwCgm.nomCgm',
                'text',
                [
                    'label' => 'label.patrimonial.compras.solicitacao.entidade',
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add(
                'fkComprasObjeto.descricao',
                'text',
                [
                    'label' => 'label.patrimonial.compras.solicitacao.objeto'
                ]
            )
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->addToIncludeJs('/patrimonial/javascripts/compras/compra-solicitacao.js');

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');

        $allEntityes = $entityManager
            ->getRepository('CoreBundle:Orcamento\Entidade')->findAll();

        foreach ($allEntityes as $entity) {
            $entidades[] = $entity->getCodEntidade();
        }
        $entidadesUnicas[] = implode(',', array_unique($entidades));

        $exercicio = $this->getExercicio();

        $fieldOptions['swcgm'] = [
            'label' => 'label.patrimonial.compras.solicitacao.solicitante',
            'property' => 'nomCgm',
            'container_css_class' => 'select2-v4-parameters ',
            'callback' => function ($admin, $property, $value) use ($entityManager) {
                /** @var AbstractSonataAdmin $admin */
                $datagrid = $admin->getDatagrid();

                /** @var QueryBuilder $query */
                $query = $datagrid->getQuery();

                $fkSolicitante = sprintf("%s.fkComprasSolicitante", $query->getRootAlias());
                $query->join($fkSolicitante, 'solicitante');
                $query->andWhere('solicitante.ativo = true');

                $datagrid->setValue($property, null, $value);
            },
            'to_string_callback' => function (SwCgm $swCgm, $property) {
                return strtoupper($swCgm);
            },
            'placeholder' => 'Selecione'
        ];

        $queryBuilder = function (EntidadeRepository $repo) use ($exercicio) {
            return $repo->getEntidadeByCgmAndExercicioQueryBuilder($exercicio);
        };

        $fieldOptions['registroPrecos'] = [
            'label' => 'label.patrimonial.compras.solicitacao.registro_precos'
        ];

        $formOptions['fkOrcamentoEntidade'] = [
            'label' => 'label.patrimonial.compras.solicitacao.entidade',
            'class' => 'CoreBundle:Orcamento\Entidade',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'query_builder' => $queryBuilder,
            'choice_value' => 'codEntidade',
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['numcgmEntrega'] = [
            'label' => 'label.patrimonial.compras.solicitacao.localizacao',
            'multiple' => false,
            'mapped' => false,
            'required' => true,
            'class' => SwCgm::class,
            'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['fkComprasSolicitacaoConvenio'] = [
            'class' => 'CoreBundle:Licitacao\Convenio',
            'label' => 'label.patrimonial.compras.solicitacao.convenio',
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['dataSolicitacao'] = [
            'label' => 'label.patrimonial.compras.solicitacao.dtSolicitacao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];
        $fieldOptions['prazoEntrega'] = [
            'label' => 'label.patrimonial.compras.solicitacao.prazoEntrega',
            'required' => true
        ];

        if (!is_null($id)) {
            /** @var Solicitacao $solicitacao */
            $solicitacao = $this->getSubject();
            $exercicio = $this->getSubject()->getExercicio();

            $queryBuilder = function (EntidadeRepository $repo) use ($exercicio) {
                return $repo->getEntidadeByCgmAndExercicioQueryBuilder($exercicio, $this->getSubject()->getFkOrcamentoEntidade()->getCodEntidade());
            };

            if ($solicitacao->getFkComprasSolicitacaoConvenio()) {
                $fieldOptions['fkComprasSolicitacaoConvenio']['data'] = $solicitacao->getFkComprasSolicitacaoConvenio()->getFkLicitacaoConvenio();
            }
            if ($solicitacao->getFkComprasSolicitacaoEntrega()) {
                $fieldOptions['numcgmEntrega']['data'] = $solicitacao->getFkComprasSolicitacaoEntrega()->getFkSwCgm();
            }

            $fieldOptions['registroPrecos']['disabled'] = true;
            $formOptions['fkOrcamentoEntidade']['disabled'] = true;

            // Caso exista uma data, setamos como readonly
            if ($solicitacao->getTimestamp()) {
                $fieldOptions['dataSolicitacao']['data'] = $solicitacao->getTimestamp();
                $fieldOptions['dataSolicitacao']['attr'] = array('readonly' => 'readonly');
            }
        }

        $formMapper
            ->with('Dados da Solicitação')
            ->add('registroPrecos', null, $fieldOptions['registroPrecos'])
            ->add(
                'exercicio',
                'text',
                [
                    'label' => 'label.patrimonial.compras.solicitacao.exercicio',
                    'data' => $exercicio,
                    'attr' => [
                        'readonly' => 'readonly'
                    ],
                ]
            )
            ->add(
                'fkOrcamentoEntidade',
                'entity',
                $formOptions['fkOrcamentoEntidade'],
                ['admin_code' => 'financeiro.admin.entidade']
            )
            ->add(
                'dataSolicitacao',
                'sonata_type_date_picker',
                $fieldOptions['dataSolicitacao']
            )
            ->add(
                'fkComprasObjeto',
                'entity',
                [
                    'label' => 'label.patrimonial.compras.solicitacao.objeto',
                    'class' => 'CoreBundle:Compras\Objeto',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'cgmRequisitante',
                'text',
                [
                    'label' => 'label.patrimonial.compras.solicitacao.requisitante',
                    'attr' => [
                        'disabled' => 'true'
                    ],
                    'data' => $this->getCurrentUser()->getFkSwCgm()->getNomCgm()
                ]
            )
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                $fieldOptions['swcgm'],
                ['admin_code' => 'core.admin.filter.sw_cgm']
            )
            ->add(
                'fkAlmoxarifadoAlmoxarifado',
                null,
                [
                    'placeholder' => 'label.selecione',
                    'label' => 'label.patrimonial.compras.solicitacao.almoxarifado',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                    'required' => true,
                ]
            )
            ->add('fkComprasSolicitacaoEntrega', 'autocomplete', $fieldOptions['numcgmEntrega'])
            ->add('prazoEntrega', null, $fieldOptions['prazoEntrega'])
            ->add(
                'observacao',
                'textarea',
                [
                    'label' => 'label.patrimonial.compras.solicitacao.observacao'
                ]
            )
            ->add('codConvenio', 'entity', $fieldOptions['fkComprasSolicitacaoConvenio'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        /** @var Solicitacao $solicitacao */
        $solicitacao = $this->getSubject();

        $exercicio = $solicitacao->getExercicio();
        $codEntidade = $solicitacao->getCodEntidade();
        $codModulo = ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS;

        $em = $this->modelManager->getEntityManager('CoreBundle:Administracao\Configuracao');
        $coModel = new ConfiguracaoModel($em);
        $boHomologaAutomatico = $coModel->pegaConfiguracao('homologacao_automatica', $codModulo, $exercicio, true);

        $solicitacao->homologacao_automatica = $boHomologaAutomatico ? true : false;

        $phomologado = $entityManager->getRepository('CoreBundle:Compras\Solicitacao')->getSolicitacaoNotHomologadoAndNotAnulada($exercicio, $solicitacao->getCodSolicitacao());
        $passivelHomologacao = (count($phomologado) > 0) ? true : false;

        $solicitacao->solicitacao = $solicitacao;
        $solicitacao->anulacao = $solicitacao->getFkComprasSolicitacaoAnulacoes();
        $solicitacao->passivel_homologacao = $passivelHomologacao;
        $cgmModel = new SwCgmModel($entityManager);
        $solicitacao->requisitante = $cgmModel->findOneByNumcgm($solicitacao->getCgmRequisitante());
        $solicitacao->passivel_anulacao_homologacao = ($solicitacao->getFkComprasSolicitacaoHomologada()) ? $solicitacao->getFkComprasSolicitacaoHomologada()->getFkComprasSolicitacaoHomologadaAnulacao() : null;

        $solicitacao->homologado = $solicitacao->getFkComprasSolicitacaoHomologada();
        $solicitacao->homologado_anulacao = null;
        if ($solicitacao->homologado) {
            $solicitacao->homologado_anulacao = $solicitacao->getFkComprasSolicitacaoHomologada()->getFkComprasSolicitacaoHomologadaAnulacao();
        }
        $solicitacaoItens = $solicitacao->getFkComprasSolicitacaoItens();
        $solicitacao->solicitacaoItem = $solicitacaoItens;

        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $itemsSolicitacao = $solicitacaoModel->montaRecuperaItensConsulta($solicitacao->getCodSolicitacao(), $codEntidade, $exercicio);

        $nuTotalVlSolicitado = 0.00;
        $nuTotalVlAnulada = 0.00;
        $nuTotalVlMapa = 0.00;

        foreach ($itemsSolicitacao as $itens) {
            $nuTotalVlSolicitado = $nuTotalVlSolicitado + $itens->vl_solicitado;
            $nuTotalVlAnulada = $nuTotalVlAnulada + $itens->vl_anulado;
            $nuTotalVlMapa = $nuTotalVlMapa + $itens->vl_mapa;
        }

        $solicitacao->nuTotalVlSolicitado = $nuTotalVlSolicitado;
        $solicitacao->nuTotalVlAnulada = $nuTotalVlAnulada;
        $solicitacao->nuTotalVlMapa = $nuTotalVlMapa;

        $solicitacao->anuladaItens = false;
        if ($nuTotalVlSolicitado <= $nuTotalVlAnulada) {
            $solicitacao->anuladaItens = true;
        }

        $assinaturaModel = new AssinaturaModel($entityManager);
        $assinaturasCgm = $assinaturaModel->carregaAssinaturas($exercicio, $codEntidade, $codModulo);
        $solicitacao->assinaturaCgm = $assinaturasCgm;
        $solicitacao->dataSolicitacao = $solicitacao->getTimestamp()->format('d/m/Y');

        $showMapper
            ->add('exercicio')
            ->add('codSolicitacao')
            ->add('observacao')
            ->add('prazoEntrega')
            ->add('registroPrecos');
    }

    /**
     * @param Solicitacao $solicitacao
     */
    public function prePersist($solicitacao)
    {
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');
        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $nextVal = $solicitacaoModel->getProximoCodSolicitacao(
            $solicitacao->getExercicio(),
            $solicitacao->getCodEntidade()
        );
        $solicitacao->setCodSolicitacao($nextVal);
        $solicitacao->setCgmRequisitante($this->getCurrentUser()->getNumCgm());
        $solicitacao->setTimestamp(new DateTimeMicrosecondPK($this->getForm()->get('dataSolicitacao')->getData()->format('Y-m-d H:i:s.u')));
    }

    /**
     * @param Solicitacao $solicitacao
     */
    public function postPersist($solicitacao)
    {
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');
        $form = $this->getForm();
        $form->get('fkComprasSolicitacaoEntrega')->getData();
        $swcgm = $form->get('fkComprasSolicitacaoEntrega')->getData();

        $solicitacaoEntregaModel = new SolicitacaoEntregaModel($entityManager);
        $solicitacaoEntrega = $solicitacaoEntregaModel->findOrCreateSolicitacaoEntrega($solicitacao, $swcgm);
        $solicitacao->setFkComprasSolicitacaoEntrega($solicitacaoEntrega);

        $convenio = $form->get('codConvenio')->getData();
        if (!is_null($convenio)) {
            $solicitacaoConvenioModel = new SolicitacaoConvenioModel($entityManager);
            $solicitacaoConvenio = $solicitacaoConvenioModel->findOrCreateSolicitacaoConvenio($solicitacao, $convenio);
            $solicitacao->setFkComprasSolicitacaoConvenio($solicitacaoConvenio);
        }

        $this->forceRedirect(
            "/patrimonial/compras/solicitacao/{$this->getObjectKey($solicitacao)}/show"
        );
    }

    /**
     * @param Solicitacao $solicitacao
     */
    public function preUpdate($solicitacao)
    {
        $requisitante = is_null($solicitacao->getCgmRequisitante()) ? $this->getCurrentUser()->getNumCgm() : $solicitacao->getCgmRequisitante();
        $solicitacao->setCgmRequisitante($requisitante);
        $solicitacao->setTimestamp(new DateTimeMicrosecondPK($this->getForm()->get('dataSolicitacao')->getData()->format('Y-m-d H:i:s.u')));

        $this->postPersist($solicitacao);
    }

    /**
     * @param Solicitacao $solicitacao
     */
    public function postUpdate($solicitacao)
    {
        $this->forceRedirect(
            "/patrimonial/compras/solicitacao/{$this->getObjectKey($solicitacao)}/show"
        );
    }
}
