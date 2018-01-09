<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Component\Config\Definition\Exception\Exception;

use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Compras\Mapa;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\HomologacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemAnulacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemDotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemReservaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaSolicitacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoAnulacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\CoreBundle\Entity\Compras\Objeto;
use Urbem\CoreBundle\Entity\Compras\TipoLicitacao;

/**
 * Class MapaAdmin
 *
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class MapaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_mapa';
    protected $baseRoutePattern = 'patrimonial/compras/mapa';

    protected $includeJs = [
        '/patrimonial/javascripts/compras/mapa.js',
    ];

    protected $datagridValues = [
        '_page'       => 1,
        '_sort_order' => 'DESC',
        '_sort_by'    => 'codMapa',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'salvar_relatorio',
            '{id}/salvar-relatorio'
        );
        $collection->add(
            'anular_all_solicitacoes',
            '{id}/anular-all-solicitacoes'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();

        $query = parent::createQuery($context);
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.exercicio = :exercicio")->setParameters(['exercicio' => $exercicio]);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codMapa', null, ['label' => 'label.patrimonial.compras.mapa.codMapa'])
            ->add('exercicio')
            ->add('fkComprasTipoLicitacao', null, [
                'field_options' => [
                    'choice_label' => 'descricao',
                    'placeholder'  => 'label.selecione',
                ],
                'label'         => 'label.patrimonial.compras.mapa.tipoCotacao',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codMapaExercicio', 'text', ['label' => 'label.patrimonial.compras.mapa.codMapa'])
            ->add('fkComprasObjeto', 'text', [
                'label' => 'label.patrimonial.compras.mapa.objeto',
            ])
            ->add('fkComprasTipoLicitacao', null, [
                'associated_property' => function ($codTipoLicitacao) {
                    $nome = $codTipoLicitacao->getDescricao();

                    return "{$nome}";
                },
                'label'               => 'label.patrimonial.compras.mapa.tipoCotacao',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Mapa');
        $mapaModel = new MapaModel($entityManager);
        $nextVal = $mapaModel->getProximoCodMapa(
            $object->getExercicio()
        );
        $object->setCodMapa($nextVal);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $formMapper
            ->with('Dados do Mapa')
            ->add('exercicio', null, [
                'attr'     =>
                    ['readonly' => 'readonly'],
                'data'     => $exercicio,
                'required' => false,
            ])
            ->add('fkComprasObjeto', 'entity', [
                'attr'        => ['class' => 'select2-parameters ',],
                'class'       => Objeto::class,
                'label'       => 'label.patrimonial.compras.mapa.objeto',
                'placeholder' => 'label.selecione',
            ])
            ->add('fkComprasTipoLicitacao', 'entity', [
                'attr'         => ['class' => 'select2-parameters ',],
                'class'        => TipoLicitacao::class,
                'choice_label' => 'descricao',
                'label'        => 'label.mapa.codTipoLicitacao',
                'placeholder'  => 'label.selecione',
            ])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        /** @var Mapa $mapa */
        $mapa = $this->getSubject();

        $mapa->mapa = $mapa;
        $mapa->anulacao = ($mapa->getFkComprasMapaSolicitacoes()->last()) ? $mapa->getFkComprasMapaSolicitacoes()->last()->getFkComprasMapaSolicitacaoAnulacoes()->last() : null;
        $solicitacoes = $entityManager->getRepository('CoreBundle:Compras\Mapa')
            ->montaRecuperaMapaSolicitacoes($mapa->getCodMapa(), $mapa->getExercicio());

        $arSolicitacoes = [];

        $solicitacoes = (count($solicitacoes) > 0) ? $solicitacoes : null;
        $items = [];
        $vlTotal = 0;
        if (count($solicitacoes) > 0) {
            $rsMapaSolicitacoes = $entityManager->getRepository(MapaItem::class)->montaRecuperaMapaSolicitacoes($mapa->getCodMapa(), $mapa->getExercicio());
            foreach ($rsMapaSolicitacoes as $rsMapaSolicitacao) {
                $arSolicitacao = [];
                $arSolicitacao['exercicio'] = $rsMapaSolicitacao['exercicio'];
                $arSolicitacao['exercicio_solicitacao'] = $rsMapaSolicitacao['exercicio'];
                $arSolicitacao['cod_solicitacao'] = $rsMapaSolicitacao['cod_solicitacao'];
                $arSolicitacao['nom_entidade'] = $rsMapaSolicitacao['nom_entidade'];
                $arSolicitacao['cod_entidade'] = $rsMapaSolicitacao['cod_entidade'];
                $arSolicitacao['valor_total'] = $rsMapaSolicitacao['valor_total'];
                $arSolicitacao['data'] = $rsMapaSolicitacao['data_solicitacao'];
                $arSolicitacao['total_mapa'] = $rsMapaSolicitacao['total_mapa'];
                $arSolicitacao['total_mapas'] = ($rsMapaSolicitacao['total_mapas'] - $arSolicitacao['total_mapa']);
                // Total anulado do Mapa em questão.
                $arSolicitacao['total_anulado'] = $rsMapaSolicitacao['total_mapa_anulado'];
                $arSolicitacao['valor_a_anular'] = 0;   /// este campo só será preenchi na rotina de anulação
                $arSolicitacao['incluir'] = false;
                $arSolicitacao['registro_precos'] = ($rsMapaSolicitacao['registro_precos'] == 't') ? 'true' : 'false';

                $arSolicitacoes[] = $arSolicitacao;

                $rsItens = $entityManager->getRepository(MapaItem::class)->montaRecuperaItemSolicitacaoMapa($arSolicitacao['cod_solicitacao'], $arSolicitacao['cod_entidade'], $arSolicitacao['exercicio_solicitacao'], null, null, $mapa->getCodMapa(), $mapa->getExercicio());
                foreach ($rsItens as $item) {
                    // Recupera a quantidade atendida do item em outros Mapas, desconsiderando o Mapa em edição.
                    $codDespesa = $codConta = null;
                    if ($item['cod_despesa']) {
                        $codDespesa = $item['cod_despesa'];
                    }
                    if ($item['cod_conta']) {
                        $codConta = $item['cod_conta'];
                    }

                    $rsQtdeAtendidaEmMapas = $entityManager->getRepository(MapaItem::class)->montaRecuperaQtdeAtendidaEmMapas($item['cod_solicitacao'], $item['cod_entidade'], $item['exercicio_solicitacao'], $item['cod_item'], $item['cod_centro'], $mapa->getCodMapa(), $mapa->getExercicio(), $codDespesa, $codConta);

                    $inQtdeAtendida = $rsQtdeAtendidaEmMapas['qtde_atendida'];

                    // Recupera o valor unitário do item.
                    $rsItemUltimaCompra = $entityManager->getRepository(MapaItem::class)->montaRecuperaValorItemUltimaCompra($item['cod_item'], $mapa->getExercicio());
                    $item['valor_ultima_compra'] = $rsItemUltimaCompra['vl_unitario_ultima_compra'];
                    $arItens = [];
                    // Dados da Solicitação.
                    $arItens['cod_entidade'] = $item['cod_entidade'];
                    $arItens['cod_solicitacao'] = $item['cod_solicitacao'];
                    $arItens['exercicio_solicitacao'] = $item['exercicio_solicitacao'];

                    // Dados do Item.
                    $arItens['cod_item'] = $item['cod_item'];
                    $arItens['nom_item'] = $item['nom_item'];
                    $arItens['complemento'] = $item['complemento'];
                    $arItens['nom_unidade'] = $item['nom_unidade'];
                    $arItens['centro_custo'] = $item['centro_custo'];
                    $arItens['cod_centro'] = $item['cod_centro'];
                    $arItens['lote'] = $item['lote'];

                    // Quantidades do Item no Mapa de Compras.
                    $arItens['quantidade_estoque'] = $item['quantidade_estoque'];
                    $arItens['quantidade_solicitada'] = (number_format($item['quantidade_solicitada'], 4, ',', '.'));
                    $arItens['quantidade_mapa'] = (number_format($item['quantidade_mapa'] - $item['quantidade_mapa_anulada'], 4, ',', '.'));
                    $arItens['quantidade_mapa_original'] = $item['quantidade_mapa'];
                    $arItens['quantidade_anulada'] = $item['quantidade_mapa_anulada'];
                    $arItens['quantidade_maxima'] = ($item['quantidade_solicitada'] - $inQtdeAtendida);
                    $arItens['quantidade_atendida'] = $inQtdeAtendida;

                    $arItens['dotacao'] = $item['dotacao'];
                    $arItens['cod_despesa'] = $item['cod_despesa'];
                    $arItens['cod_conta'] = $item['cod_conta'];
                    $arItens['vl_mapa'] = $item['valor_total_mapa'];
                    $arItens['cod_reserva'] = $item['cod_reserva'];
                    $arItens['exercicio_reserva'] = $item['exercicio_reserva'];

                    // Valores Monetários.
                    $arItens['valor_unitario'] = number_format($item['valor_unitario'], 2, ",", ".");
                    $arItens['valor_ultima_compra'] = $item['valor_ultima_compra'];

                    // Total do Mapa corrente deve ser o valor unitário * quantidade em mapa corrente.
                    $vlTotal = $vlTotal + ($item['valor_unitario'] * $arItens['quantidade_mapa']);
                    $arItens['valor_total_mapa'] = number_format(($item['valor_unitario'] * $arItens['quantidade_mapa']), 2, ",", ".");
                    $arItens['valor_total_mapa_original'] = $arItens['valor_total_mapa'];

                    $arItens['cod_reserva_solicitacao'] = $item['cod_reserva_solicitacao'];
                    $arItens['exercicio_reserva_solicitacao'] = $item['exercicio_reserva_solicitacao'];
                    $arItens['vl_reserva_solicitacao'] = $item['vl_reserva_solicitacao'];

                    // Verifica se a dotação já foi informada na solicitação ou se ainda está pendente.
                    $arItens['boDotacao'] = (is_numeric($item['dotacao'])) ? 'T' : 'F';

                    $arItens['dotacao_nom_conta'] = $item['dotacao_nom_conta'];
                    $arItens['conta_despesa'] = $item['conta_despesa'];  //-> desdobramento
                    $arItens['nom_conta'] = $item['nom_conta'];
                    $arItens['cod_estrutural'] = $item['cod_estrutural'];
                    $arItens['vl_reserva'] = $item['vl_reserva'];
                    $arItens['vl_reserva_homologacao'] = $item['vl_reserva'];
                    $arItens['reservaHomologacao'] = $item['quantidade_mapa'] < $item['quantidade_maxima'];

                    if ($item['vl_reserva'] != '0.00') {
                        // Se já existir reserva de saldo para o item, não pode ser alterado no mapa.
                        $arItens['boReserva'] = 'T';
                    } else {
                        $arItens['boReserva'] = 'F';
                        $arItens['vl_reserva'] = $arItens['valor_total_mapa'];
                    }
                    $items[] = $arItens;
                }
            }
        } else {
            $items = null;
        }

        $mapa->solicitacoes = $solicitacoes;
        $mapa->itens = $items;
        $mapa->vlTotalItems = number_format($vlTotal, 2, ",", ".");


        $showMapper
            ->add('codMapa')
            ->add('exercicio');
    }

    /**
     * {@inheritdoc}
     */
    public function preRemove($object)
    {
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Mapa');
        $mapaItemReservaModel = new MapaItemReservaModel($entityManager);
        $mapaItemModel = new MapaItemModel($entityManager);
        $rsReservas = $mapaItemModel->getRecuperaReservas($object->getExercicio(), $object->getCodMapa());


        try {
            if (!is_null($rsReservas)) {
                foreach ($rsReservas as $reserva) {
                    // Verifica se existe Reserva de Saldo criada pela Solicitação.
                    if ($reserva->cod_reserva_solicitacao) {
                        // Verifica se a reserva da Solicitação está anulada.
                        $orcamentoReservaSaldoAnulada = $entityManager
                            ->getRepository('CoreBundle:Orcamento\ReservaSaldosAnulada')
                            ->findOneBy(
                                [
                                    'exercicio'  => $reserva->exercicio_reserva_solicitacao,
                                    'codReserva' => $reserva->cod_reserva_solicitacao,
                                ]
                            );

                        // Caso exista uma anulação para a reserva da Solicitação e tiver saldo, exclui a anulação e atualiza o valor da reserva da Solicitação.
                        if ($orcamentoReservaSaldoAnulada) {
                            $mapaItemReservaModel->remove($orcamentoReservaSaldoAnulada);
                            // A anulação da reserva de saldo é excluída e a reserva da Solicitação volta a ter o valor da reserva do Mapa excluida.
                            $nuVlReservaSaldoSolicitacao = $reserva->vl_reserva;
                        } else {
                            $orcamentoReservaSaldos = $entityManager
                                ->getRepository('CoreBundle:Orcamento\ReservaSaldos')
                                ->findOneBy(
                                    [
                                        'exercicio'  => $reserva->exercicio_reserva_solicitacao,
                                        'codReserva' => $reserva->cod_reserva_solicitacao,
                                    ]
                                );

                            // Atualiza o valor da reserva da solicitação
                            $nuVlReservaSaldoSolicitacao = $orcamentoReservaSaldos->getVlReserva() + $reserva->vl_reserva;
                        }

                        $orcamentoReservaSaldos = $entityManager
                            ->getRepository('CoreBundle:Orcamento\ReservaSaldos')
                            ->findOneBy(
                                [
                                    'exercicio'  => $reserva->exercicio_reserva_solicitacao,
                                    'codReserva' => $reserva->cod_reserva_solicitacao,
                                ]
                            );

                        $orcamentoReservaSaldosModel = new ReservaSaldosModel($entityManager);
                        $obTOrcamentoReservaSaldos = $orcamentoReservaSaldosModel->alteraReservaSaldo(
                            $reserva->cod_reserva_solicitacao,
                            $reserva->exercicio_reserva_solicitacao,
                            $orcamentoReservaSaldos->getVlReserva()
                        );
                        if (!$obTOrcamentoReservaSaldos) {
                            $stMensagem = 'Não foi possível alterar a reserva da Solicitação de Compras para o item ' . $rsReservas->getCampo('cod_item');
                        }
                    }

                    // Dados para montar as mensagens de anulação de reserva de saldo.
                    $inNumCgm = $this->getCurrentUser()->getFkSwCgm()->getNumcgm();
                    $stNomEntidade = $object->getFkComprasCompraDiretas()->last()->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
                    $stEntidade = $object->getFkComprasCompraDiretas()->last()->getCodEntidade() . " - " . $stNomEntidade;

                    // Fim dados mensagem.

                    $stMsgReservaAnulada = "Entidade: " . $stEntidade . ", ";
                    $stMsgReservaAnulada .= "Mapa de Compras: " . $object->getCodMapa() . "/" . $object->getExercicio() . ", ";
                    $stMsgReservaAnulada .= "Item: " . $reserva->cod_item . ", ";
                    $stMsgReservaAnulada .= "Centro de Custo: " . $reserva->cod_centro . " ";

                    $reservaSaldosModel = new ReservaSaldosModel($entityManager);
                    $reserva = $reservaSaldosModel->getOneReservaSaldos($reserva->cod_reserva, $reserva->exercicio_reserva);

                    if (!$reserva->getFkOrcamentoReservaSaldosAnuladas()->last()) {
                        // Anulando a Reserva de Saldo criada pelo Mapa de Compras
                        $obTOrcamentoReservaSaldosAnulada = new ReservaSaldosAnulada();

                        $obTOrcamentoReservaSaldosAnulada->setFkOrcamentoReservaSaldos($reserva);
                        $obTOrcamentoReservaSaldosAnulada->setDtAnulacao(new \DateTime());
                        $obTOrcamentoReservaSaldosAnulada->setMotivoAnulacao($stMsgReservaAnulada);
                        $reservaSaldosModel->save($obTOrcamentoReservaSaldosAnulada);
                    }
                }
            }

            // Apaga as reservas existentes para itens do Mapa.
            $mapaItemReserva = $mapaItemReservaModel->getOneMapaItemReserva($object->getCodMapa(), $object->getExercicio());
            if (is_object($mapaItemReserva)) {
                $mapaItemReservaModel->remove($mapaItemReserva);
            }

            // Exclui as anulações do itens que sejam do Mapa de Compras.
            $obTComprasMapaItemAnulacaoModel = new MapaItemAnulacaoModel($entityManager);
            $obTComprasMapaItemAnulacao = $obTComprasMapaItemAnulacaoModel->getOneMapaItemAnulacao(
                $object->getCodMapa(),
                $object->getExercicio()
            );

            if (is_object($obTComprasMapaItemAnulacao)) {
                $obTComprasMapaItemAnulacaoModel->remove($obTComprasMapaItemAnulacao);
            }

            // Verifica se o objeto: Mapa existe uma solicitação atrelada
            if (is_object($object->getFkComprasMapaSolicitacoes()->last())) {
                // Exclui as anulações para solicitações que sejam do Mapa de Compras.
                $obTmapaSolicitacaoAnulacaoModel = new SolicitacaoAnulacaoModel($entityManager);
                $solicitacaoAnulacao = $obTmapaSolicitacaoAnulacaoModel->getOneSolicitacaoAnulacao(
                    $object->getFkComprasMapaSolicitacoes()->last()->getCodSolicitacao(),
                    $object->getExercicio()
                );

                if (is_object($solicitacaoAnulacao)) {
                    $obTmapaSolicitacaoAnulacaoModel->remove($solicitacaoAnulacao);
                }
            }


            // Exclui as dotações dos itens do Mapa de Compras.
            $obTComprasMapaItemDotacaoModel = new MapaItemDotacaoModel($entityManager);
            $dotacao = $obTComprasMapaItemDotacaoModel->getOneMapaItemDotacaoByCodMapaAndExercicio(
                $object->getCodMapa(),
                $object->getExercicio()
            );

            if (is_object($dotacao)) {
                $obTComprasMapaItemDotacaoModel->remove($dotacao);
            }

            // Exclui os itens do Mapa de Compras.
            $obTComprasMapaItemModel = new MapaItemModel($entityManager);
            $mapaItem = $obTComprasMapaItemModel->getOneMapaItem(
                $object->getCodMapa(),
                $object->getExercicio()
            );

            if (is_object($mapaItem)) {
                $obTComprasMapaItemModel->remove($mapaItem);
            }

            // Exclui o vínculo entre Solicitação de Compras e Mapa de Compras.
            $obTComprasMapaSolicitacaoModel = new MapaSolicitacaoModel($entityManager);
            $mapaSolicitacao = $obTComprasMapaSolicitacaoModel->getOneMapaSolicitacao(
                $object->getCodMapa(),
                $object->getExercicio()
            );
            if (is_object($mapaSolicitacao)) {
                $obTComprasMapaSolicitacaoModel->remove($mapaSolicitacao);
            }

            // Exclui a Compra Direta.
            $obTComprasDiretaModel = new CompraDiretaModel($entityManager);
            /** @var CompraDireta $comprasDireta */
            $comprasDireta = $object->getFkComprasCompraDiretas();
            if (is_object($comprasDireta)) {
                /** @var CompraDireta $compraDireta */
                foreach ($comprasDireta as $compraDireta) {
                    $obTComprasHomologacaoModel = new HomologacaoModel($entityManager);
                    $homologacao = $compraDireta->getFkComprasHomologacoes();
                    if (is_object($homologacao->last())) {
                        $obTComprasHomologacaoModel->remove($homologacao->last());
                    }
                    $obTComprasDiretaModel->remove($compraDireta);
                }
            }

            // Exclui o Mapa de Compras.
            $obTComprasMapaModel = new MapaModel($entityManager);
            $obTComprasMapaModel->remove($object);
        } catch (Exception $e) {
            throw $e;
        }

        $this->redirectByRoute('urbem_patrimonial_compras_mapa_list');
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $this->forceRedirect(
            "/patrimonial/compras/mapa/{$this->getObjectKey($object)}/show"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $this->forceRedirect(
            "/patrimonial/compras/mapa/{$this->getObjectKey($object)}/show"
        );
    }
}
