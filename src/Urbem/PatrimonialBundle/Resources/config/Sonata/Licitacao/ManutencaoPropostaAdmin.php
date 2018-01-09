<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\ParameterBag;
use Urbem\CoreBundle\Entity\Licitacao\Comissao;
use Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Licitacao\CriterioJulgamento;
use Urbem\CoreBundle\Entity\Licitacao\TipoChamadaPublica;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ComissaoLicitacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ComissaoMembrosModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ComissaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ManutencaoPropostaModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Compras\Objeto;
use Urbem\CoreBundle\Entity\Compras;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class ManutencaoPropostaAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class ManutencaoPropostaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_manutencao_proposta';
    protected $baseRoutePattern = 'patrimonial/licitacao/manutencao-proposta';
    protected $customHeader = 'PatrimonialBundle:Sonata\Licitacao\ManutencaoProposta\CRUD:header.html.twig';

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;

    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/manutencao-proposta.js',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'get_itens_by_fornecedor',
            'get-itens-by-fornecedor/'
        );
    }


    public function createQuery($context = 'list')
    {
        /**
         * Auxilia na execuçao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $exercicio = (!$this->getRequest()->query->get('filter')['exercicio']['value'] ?
            $this->getExercicio() : $this->getRequest()->query->get('filter')['exercicio']['value']);

        $licitacaoModel = new LicitacaoModel($entityManager);

        $query = parent::createQuery($context);
        $query = $licitacaoModel->getLicitacaoManutencaoPropostas($query, $exercicio);

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getExercicio();
        $datagridMapper
            ->add('exercicio', null, [
                'label' => 'label.patrimonial.licitacao.exercicio'
            ], null, [

            ])
            ->add(
                'fkOrcamentoEntidade',
                'composite_filter',
                [
                    'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade'
                ],
                null,
                [
                    'class' => Orcamento\Entidade::class,
                    'choice_label' => function (Orcamento\Entidade $entidade) {
                        return $entidade->getCodEntidade().' - '.
                            $entidade->getFkSwCgm()->getNomCgm();
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'query_builder' => function (EntidadeRepository $em) use ($exercicio) {
                        return $em->findAllByExercicioAsQueryBuilder($exercicio);
                    },
                    'placeholder' => 'label.selecione'
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add(
                'fkSwProcesso',
                'composite_filter',
                [
                    'label' => 'label.comprasDireta.codProcesso',
                    'admin_code' => 'administrativo.admin.processo',
                ],
                'autocomplete',
                [
                    'class' => SwProcesso::class,
                    'route' => ['name' => 'urbem_core_filter_swprocesso_autocomplete'],
                    'attr' => [

                        'class' => 'select2-parameters '
                    ],
                    'placeholder' => 'Selecione'
                ]
            )
            ->add('fkComprasModalidade', null, [
                'label' => 'label.comprasDireta.codModalidade',
                'choice_label' => function (Compras\Modalidade $modalidade) {
                    return $modalidade->getCodModalidade().' - '.
                        $modalidade->getDescricao();
                },
                'placeholder' => 'label.selecione'
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codLicitacaoExercicio', null, ['label' => 'label.patrimonial.licitacao.codLicitacao'])
            ->add('fkOrcamentoEntidade', 'text', [
                'label' => 'label.patrimonial.licitacao.entidade',
                'admin_code' => 'financeiro.admin.entidade'
            ])
            ->add('fkSwProcesso', 'text', [
                'label' => 'label.comprasDireta.codProcesso',
                'admin_code' => 'administrativo.admin.processo'
            ])
            ->add('fkComprasModalidade', 'text', [
                'label' => 'label.comprasDireta.codModalidade'
            ])
            ->add('_action', 'actions', [
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                )
            ]);
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $entityManager */
        $em = $this->getModelManager()->getEntityManager($this->getClass());

        /** @var Licitacao $licitacao */
        $this->proposta = $this->getSubject();

        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $licitacaoModel = new LicitacaoModel($entityManager);
        list($codLicitacao, $codModalidade, $codEntidade, $exercicio) = explode('~', $this->getAdminRequestId());

        $edital = $entityManager
            ->getRepository(Edital::class)
            ->findOneBy([
                'codLicitacao' => $codLicitacao,
                'codModalidade' => $codModalidade,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        $numEdital = is_object($edital) ? $edital->getNumEdital() : null;

        $participantes = $licitacaoModel->montaRecuperaParticipanteLicitacaoManutencaoPropostas(
            $codLicitacao,
            $codModalidade,
            $codEntidade,
            $exercicio,
            $numEdital
        );

        $swFornecedores = array();
        if (!empty($participantes)) {
            foreach ($participantes as $participante) {
                $swFornecedores[] = $participante->cgm_fornecedor;
            }
        }

        $fieldOptions = array();
        $fieldOptions['fornecedores'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'class' => Compras\Fornecedor::class,
            'label' => 'label.patrimonial.licitacao.fornecedores',
            'query_builder' => function ($entityManager) use ($swFornecedores) {
                $qb = $entityManager->createQueryBuilder('o');
                $qb->where('o.cgmFornecedor IN (:cgmFornecedor)');
                $qb->setParameter('cgmFornecedor', $swFornecedores);
                return $qb;
            },
            'placeholder' => 'label.selecione'
        ];

        // Processa dtManutencao
        $mapaItemModel = new MapaItemModel($em);
        $cotacaoValida = $mapaItemModel->montaRecuperaMapaCotacaoValida(
            $this->proposta->getFkComprasMapa()->getCodMapa(),
            $this->proposta->getFkComprasMapa()->getExercicio()
        );

        $date = new \DateTime();
        if (!empty($cotacaoValida)) {
            // Consulta Cotacao
            $cotacaoModel = new CotacaoModel($em);
            /** @var Compras\Cotacao $cotacao */
            $cotacao = $cotacaoModel->getCotacao($cotacaoValida->cod_cotacao, $cotacaoValida->exercicio_cotacao);
            $date = $cotacao->getTimestamp();
        } else {
            $date = $this->proposta->getTimestamp();
        }

        $formMapper
            ->with(' ')
                ->add(
                    'dtManutencao',
                    'datepkpicker',
                    [
                        'mapped' => false,
                        'format' => 'dd/MM/yyyy',
                        'pk_class' => DateTimeMicrosecondPK::class,
                        'label' => 'label.patrimonial.licitacao.manutencaoProposta.dtManutencao',
                        'data' => $date
                    ]
                )
            ->end()
            ->with('label.patrimonial.licitacao.manutencaoProposta.participantes')
                ->add('codLicitacao', 'hidden')
                ->add('exercicio', 'hidden')
                ->add('codModalidade', 'hidden')
                ->add('codEntidade', 'hidden')
                ->add('participantes', 'entity', $fieldOptions['fornecedores'])
            ->end()
            ->with('label.patrimonial.licitacao.manutencaoProposta.itens', [
                'class' => 'col s12 manutencao-items'
            ])
            ->end();
    }

    /**
     * @param Licitacao $licitacao
     */
    public function preUpdate($licitacao)
    {
        /** @var EntityManager $entityManager */
        $em = $this->getModelManager()->getEntityManager($this->getClass());
        /** @var ParameterBag $request */
        $request = $this->request->request;
        $form = $this->getForm();
        $exercicio = $this->getExercicio();

        $mapaItemModel = new MapaItemModel($em);
        $manutencaoPropostaModel = new ManutencaoPropostaModel($em);

        $cotacaoValida = $mapaItemModel->montaRecuperaMapaCotacaoValida(
            $licitacao->getFkComprasMapa()->getCodMapa(),
            $licitacao->getFkComprasMapa()->getExercicio()
        );
        if (empty($cotacaoValida)) {
            // Cria uma Cotacao
            $cotacao = $manutencaoPropostaModel->saveCotacao($exercicio, $form);

            // Cria um MapaCotacao
            $mapaCotacao = $manutencaoPropostaModel->saveMapaCotacao($cotacao, $licitacao);

            $this->processaItens($licitacao, $request, $cotacao, $form);
        } else {
            // Consulta Cotacao
            $cotacaoModel = new CotacaoModel($em);
            /** @var Compras\Cotacao $cotacao */
            $cotacao = $cotacaoModel->getCotacao($cotacaoValida->cod_cotacao, $cotacaoValida->exercicio_cotacao);
            $cotacao->setTimestamp($form->get('dtManutencao')->getData());
            $manutencaoPropostaModel->save($cotacao);

            /** @var Compras\CotacaoItem $cotacaoItem */
            foreach ($cotacao->getFkComprasCotacaoItens() as $cotacaoItem) {
                if (!empty($request->get('item_vlUnit')[$cotacaoItem->getCodItem()]) &&
                    !empty($request->get('item_quantidade')[$cotacaoItem->getCodItem()]) &&
                    !empty($request->get('item_data')[$cotacaoItem->getCodItem()]) &&
                    !empty($request->get('item_valorTotal')[$cotacaoItem->getCodItem()]) &&
                    !empty($request->get('item_marca')[$cotacaoItem->getCodItem()]) ) {
                    $cotacaoFornecedorItens = $em
                        ->getRepository(Compras\CotacaoFornecedorItem::class)
                        ->findBy([
                            'codCotacao' => $cotacao->getCodCotacao(),
                            'exercicio' => $cotacao->getExercicio(),
                            'codItem' => $cotacaoItem->getCodItem(),
                            'cgmFornecedor' => $form->get('participantes')->getData()->getCgmFornecedor(),
                            'lote' => $cotacaoItem->getLote()
                        ]);

                    /** @var Compras\CotacaoFornecedorItem $cotacaoFornecedorItem */
                    foreach ($cotacaoFornecedorItens as $cotacaoFornecedorItem) {
                        foreach ($cotacaoFornecedorItem->getFkLicitacaoCotacaoLicitacoes() as $cotacaoLicitacao) {
                            // Remove CotacaoLicitacao
                            $manutencaoPropostaModel->remove($cotacaoLicitacao);
                        }
                        // Remove CotacaoFornecedorItem
                        $manutencaoPropostaModel->remove($cotacaoFornecedorItem);
                    }
                }
            }

            $this->processaItens($licitacao, $request, $cotacao, $form);
        }
    }

    /**
     * @param Licitacao $licitacao
     * @param ParameterBag $request
     * @param Compras\Cotacao $cotacao
     * @param Form $form
     */
    public function processaItens($licitacao, $request, $cotacao, $form)
    {
        /** @var EntityManager $entityManager */
        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $manutencaoPropostaModel = new ManutencaoPropostaModel($em);

        /** @var Compras\MapaSolicitacao $solicitacao */
        foreach ($licitacao->getFkComprasMapa()->getFkComprasMapaSolicitacoes() as $solicitacao) {
            /** @var Compras\MapaItem $item */
            foreach ($solicitacao->getFkComprasMapaItens() as $item) {
                if (!empty($request->get('item_vlUnit')[$item->getCodItem()]) &&
                    !empty($request->get('item_quantidade')[$item->getCodItem()]) &&
                    !empty($request->get('item_data')[$item->getCodItem()]) &&
                    !empty($request->get('item_valorTotal')[$item->getCodItem()]) &&
                    !empty($request->get('item_marca')[$item->getCodItem()]) ) {
                    // Cria as CotacaoItem
                    $cotacaoItem = $manutencaoPropostaModel->findOrCreateCotacaoItem($cotacao, $request, $item);

                    // Consulta ou cria CatalogoItemMarca
                    $catalogoItemMarcaModel = new CatalogoItemMarcaModel($em);
                    $catalogoItemMarca = $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca(
                        $item->getCodItem(),
                        $request->get('item_marca')[$item->getCodItem()]
                    );

                    // Cria CotacaoFornecedorItem
                    $cotacaoFornecedorItem = $manutencaoPropostaModel->saveCotacaoFornecedorItem($cotacaoItem, $request, $catalogoItemMarca, $form);

                    // Cria CotacaoLicitacao
                    $cotacaoLicitacao = $manutencaoPropostaModel->saveCotacaoLicitacao($cotacaoFornecedorItem, $licitacao);
                }
            }
        }
    }
}
