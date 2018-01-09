<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;

use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\ConfiguracaoLancamentoContaDespesaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoRequisicaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaLancamentoModel;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ManutencaoModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\AlmoxarifadoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Entity\Orcamento;

/**
 * Class DevolucaoRequisicaoAdmin
 */
class DevolucaoRequisicaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_entrada_devolucao_requisicao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/entrada/requisicao/devolucao';

    const TIPO_REQUISICAO = "E";

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/devolucao-requisicao.js',
    ];

    protected $datagridValues = [
        '_page'         => 1,
        '_sort_order'   => 'DESC',
        '_sort_by'      => 'exercicio'
    ];

    public $customHeader = 'PatrimonialBundle:Sonata\Almoxarifado\RequisicaoDevolucao\CRUD:header.html.twig';
    public $exibirBotaoIncluir = false;

    /**
     * @param RouteCollection $routeCollection
     */
    public function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept(['list', 'edit']);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        /**
         * Auxilia na execuçao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $requisicaoModel = new RequisicaoModel($entityManager);

        $query = parent::createQuery($context);
        $query = $requisicaoModel->getRequisicoes($query, self::TIPO_REQUISICAO);
        
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(['codRequisicao']);

        $datagridMapper
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.almoxarifado.requisicao.almoxarifado'], null, [
                'choice_label' => 'fkSwCgm.nomCgm',
                'query_builder' => function (AlmoxarifadoRepository $almoxarifadoRepository) {
                    $queryBuilder = $almoxarifadoRepository->createQueryBuilder('almoxarifado');
                    $queryBuilder->join('almoxarifado.fkAlmoxarifadoRequisicoes', 'requisicao');

                    return $queryBuilder;
                }
            ])
            ->add('codRequisicao', null, ['label' => 'label.almoxarifado.requisicao.codRequisicao'])
            ->add('exercicio', null, ['label' => 'label.almoxarifado.requisicao.exercicio'])
            ->add('dtRequisicao', null, [
                'label' => 'label.almoxarifado.requisicao.dtRequisicao'
            ], 'sonata_type_date_picker', [
                'format' => 'd/M/y'
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkAlmoxarifadoAlmoxarifado.fkSwCgm.nomCgm', null, ['label' => 'label.almoxarifado.requisicao.almoxarifado'])
            ->add('codRequisicao', null, ['label' => 'label.almoxarifado.requisicao.devolucao.codRequisicao'])
            ->add('exercicio', null, ['label' => 'label.almoxarifado.requisicao.exercicio'])
            ->add('dtRequisicao', null, ['label' => 'label.almoxarifado.requisicao.devolucao.dtRequisicao'])
        ;

        $actions = [
            'actions' => [
                'edit' => ['template' => 'PatrimonialBundle:Sonata/Almoxarifado/DevolucaoRequisicao/CRUD:list__action_edit.html.twig']
            ]
        ];

        $listMapper->add('_action', 'actions', $actions);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->getConfigurationPool()->getContainer()->get('Doctrine')->getManager();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var Almoxarifado\Requisicao $requisicao */
        $requisicao = $this->getSubject();

        $swCgmModel = new SwCgmModel($entityManager);
        $swCgm = $swCgmModel->findOneByNumcgm($requisicao->getCgmRequisitante());

        $requisicao->fkSwCgmRequisitante = $swCgm;

        $withLabel = self::TIPO_REQUISICAO == 'S' ?
            'label.almoxarifado.requisicao.saida.saida' :
            'label.almoxarifado.requisicao.devolucao.devolucao' ;

        $formMapper
            ->with($withLabel)
                ->add('fkAlmoxarifadoRequisicaoItens', 'sonata_type_collection', [
                    'btn_add' => false,
                    'label' => false,
                    'type_options' => [
                        'btn_add' => false,
                        'delete' => false
                    ]
                ], [
                    'admin_code' => 'patrimonial.admin.devolucao_requisicao_item',
                    'edit' => 'inline',
                ])
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form  = $this->getForm();

        /** @var Form $fkAlmoxarifadoRequisicaoItemForm */
        foreach ($form->get('fkAlmoxarifadoRequisicaoItens') as $fkAlmoxarifadoRequisicaoItemForm) {
            /** @var boolean $devolver */
            $devolver = $fkAlmoxarifadoRequisicaoItemForm->get('devolverItem')->getData();
            $quantidade = $fkAlmoxarifadoRequisicaoItemForm->get('quantidade')->getData();
            $quantidade = abs($quantidade);

            /**
             * Validaçao efetuada somente se a opçao de devolvero
             * item estiver marcada e a quantidade for maior que 0 (zero)
             */
            if (true == $devolver
                && $quantidade > 0) {
                /** @var RequisicaoItem $requisicaoItem */
                $requisicaoItem = $fkAlmoxarifadoRequisicaoItemForm->getNormData();

                $saldos = (new RequisicaoItemModel($entityManager))
                    ->getSaldoEstoqueRequisitadoAtendido($requisicaoItem);

                $saldoAtendido = abs($saldos['saldo_atendido']);

                /**
                 * Quantidade de Entrada (Quantidade inserida)
                 * não pode ser maior que saldo atendido.
                 */
                if ($saldoAtendido < $quantidade) {
                    $message = $this->trans('patrimonial.anulacaoRequisicao.error.quantidadeGreaterThanSaldoAtendido', [], 'flashes');
                    $errorElement->with('fkAlmoxarifadoRequisicaoItens')->addViolation($message);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($requisicao)
    {
        $this->geraDadosProcessoRequisicao();
    }

    /**
     * Processa a Requisicao
     */
    public function geraDadosProcessoRequisicao()
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        /** @var \Symfony\Component\Form\Form $form */
        $form  = $this->getForm();

        /** @var Administracao\Usuario $usuario */
        $usuario = $this->getCurrentUser();

        $exercicio = $this->getExercicio();

        foreach ($form->get('fkAlmoxarifadoRequisicaoItens') as $subForm) {
            $quantidade = $subForm->get('quantidade')->getData();
            $quantidade = abs($quantidade);

            /** @var boolean */
            $devolver = $subForm->get('devolverItem')->getData();

            if (true == $devolver
                && $quantidade > 0) {

                /** @var Almoxarifado\RequisicaoItem $requisicaoItem */
                $requisicaoItem = $subForm->getNormData();

                /** @var Orcamento\ContaDespesa $contaDespesa */
                $contaDespesa = $subForm->get('codContaDespesa')->getData();

                /** @var String $complemento */
                $complemento = $subForm->get('complemento')->getData();

                $configuracaoLancamentoContaDespesaItemModel =
                    new ConfiguracaoLancamentoContaDespesaItemModel($entityManager);
                $configuracaoLancamentoContaDespesaItemModel
                    ->buildOneBasedOnRequisicaoItem($requisicaoItem, $contaDespesa);

                $lancamentoRequisicaoModel = new LancamentoRequisicaoModel($entityManager);
                $lancamentoRequisicao = $lancamentoRequisicaoModel->buildOneBasedOnRequisicaoItem($requisicaoItem);

                $naturezaLancamentoModel = new NaturezaLancamentoModel($entityManager);
                $naturezaLancamento = $naturezaLancamentoModel->buildOne($usuario->getFkSwCgm(), $exercicio, self::TIPO_REQUISICAO);

                $lancamentoMaterialModel = new LancamentoMaterialModel($entityManager);
                $lancamentoMaterial = $lancamentoMaterialModel->buildOneBasedRequisicaoItem(
                    $requisicaoItem,
                    $lancamentoRequisicao,
                    $naturezaLancamento,
                    $quantidade,
                    $complemento
                );
                $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);

                $requisicaoItemModel = new RequisicaoItemModel($entityManager);

                if ($requisicaoItemModel->isFrotaItem($requisicaoItem)) {
                    /** @var Frota\Veiculo $veiculo */
                    $veiculo = $subForm->get('codVeiculo')->getData();
                    $km = $subForm->get('km')->getData();

                    if (self::TIPO_REQUISICAO == 'S') {
                        $manutencaoModel = new ManutencaoModel($entityManager);
                        $manutencaoModel->buildManutencaoByRequisicaoItem(
                            $lancamentoRequisicao,
                            $veiculo,
                            $exercicio,
                            $km,
                            $complemento
                        );
                    }
                }

                $entityManager->persist($lancamentoRequisicao);
                $entityManager->persist($naturezaLancamento);
                $entityManager->persist($lancamentoMaterial);

                $entityManager->flush();
            }
        }
    }
}
