<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CatalogoItemRepository;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\MapaItemRepository;

class MapaItemModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var MapaItemRepository|null  */
    protected $repository = null;

    /**
     * MapaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\MapaItem::class);
    }

    /**
     * @param Compras\SolicitacaoItem $solicitacaoItem
     * @param Compras\MapaSolicitacao $mapaSolicitacao
     * @param                         $quantidade
     * @param                         $vlTotal
     *
     * @return MapaItem
     */
    public function buildOne(Compras\SolicitacaoItem $solicitacaoItem, Compras\MapaSolicitacao $mapaSolicitacao, $quantidade, $vlTotal, $lote)
    {
        $mapaItem = new MapaItem();
        $mapaItem->setFkComprasSolicitacaoItem($solicitacaoItem);
        $mapaItem->setFkComprasMapaSolicitacao($mapaSolicitacao);
        $mapaItem->setQuantidade($quantidade);
        $mapaItem->setVlTotal($vlTotal);
        $mapaItem->setLote($lote);

        return $mapaItem;
    }

    /**
     * @param int        $codSolicitacao
     * @param int        $codEntidade
     * @param string|int $exercicio
     *
     * @return array
     */
    public function montaRecuperaItemsSolicitacaoParaMapa($codSolicitacao, $codEntidade, $exercicio)
    {
        $itens = $this->montaRecuperaIncluirSolicitacaoMapa($codSolicitacao, $codEntidade, $exercicio);

        $itemsSolicitacao = [];
        foreach ($itens as $index => $item) {
            if ($item->quantidade_atendida < $item->quantidade_solicitada) {
                $itemsSolicitacao[] = $itens[$index];
            }
        }

        return $itemsSolicitacao;
    }

    public function formataSolicitacaoMapa($items, $exercicio, $codEntidade, $codSolicitacao)
    {
        /** @var Compras\Solicitacao $solicitacao */
        $solicitacao = $this->entityManager->getRepository(Compras\Solicitacao::class)->findOneBy([
            'exercicio'      => $exercicio,
            'codEntidade'    => $codEntidade,
            'codSolicitacao' => $codSolicitacao,
        ]);

        $reservaAutorizada = (new ConfiguracaoModel($this->entityManager))->getConfiguracao(
            'reserva_autorizacao',
            Modulo::MODULO_PATRIMONIAL_COMPRAS,
            true,
            $exercicio
        );
        $reservaAutorizada = filter_var($reservaAutorizada, FILTER_VALIDATE_BOOLEAN);

        foreach ($items as &$item) {
            $item = (object) $item;

            $montaRecuperaQtdeAtendidaEmMapasParams = [
                $item->cod_solicitacao,
                $item->cod_entidade,
                $item->exercicio_solicitacao,
                $item->cod_item,
                $item->cod_centro,
                null,
                null
            ];

            $montaRecuperaQtdeAtendidaEmMapasParams[] = !empty($item->cod_despesa) ? $item->cod_despesa : null;
            $montaRecuperaQtdeAtendidaEmMapasParams[] = !empty($item->cod_conta) ? $item->cod_conta : null;

            $result = call_user_func_array([$this, 'montaRecuperaQtdeAtendidaEmMapas'], $montaRecuperaQtdeAtendidaEmMapasParams);
            $item->quantidade_atendida = $result['qtde_atendida'];

            $result = $this->montaRecuperaValorItemUltimaCompra($item->cod_item, $item->exercicio_solicitacao);
            $item->valor_ultima_compra = isset($result['valor_ultima_compra']) ? $result['valor_ultima_compra'] : '';

            $item->quantidade_solicitada = bcsub($item->quantidade, $item->quantidade_anulada, 4);
            $item->quantidade_mapa = bcsub($item->quantidade_solicitada, $item->quantidade_atendida, 4);
            $item->quantidade_mapa_original = $item->quantidade_mapa;

            $item->quantidade_maxima = $item->quantidade_mapa;

            $item->valor_total_mapa = bcmul($item->valor_unitario, bcsub($item->quantidade_solicitada, $item->quantidade_atendida, 4), 2);
            $item->valor_total_mapa_original = $item->valor_total_mapa;

            $item->vl_reserva_homologacao = $item->vl_reserva;

            if ($item->vl_reserva < $item->vl_total) {
                $item->cod_reserva_solicitacao = $item->cod_reserva;
                $item->exercicio_reserva_solicitacao = $item->exercicio_reserva;
            }

            $item->dotacao = $item->cod_despesa;
            $item->boDotacao = is_null($item->cod_despesa) ? 'F' : 'T';

            // Se existir reserva de saldo para o item, não permite alterar no mapa.
            if ($item->vl_reserva != '0.00' || !empty($item->cod_reserva)) {
                $item->boReserva = 'T';
            } else {
                $item->boReserva = 'F';
                $item->vl_reserva = $item->valor_total_mapa;
            }

            if ($solicitacao->getRegistroPrecos() == true || $reservaAutorizada == true) {
                $item->vl_reserva = '0.00';
                $item->vl_reserva_homologacao = $item->vl_reserva;
            }

            $item->isRegistroPreco = $solicitacao->getRegistroPrecos();
        }

        return $items;
    }

    /**
     * @param bool $codSolicitacao
     * @param bool $codEntidade
     * @param bool $exercicio
     * @param bool $codItem
     * @param bool $codCentro
     *
     * @return array
     */
    public function montaRecuperaIncluirSolicitacaoMapa($codSolicitacao, $codEntidade, $exercicio, $codItem = false, $codCentro = false)
    {
        $items = $this->repository->montaRecuperaIncluirSolicitacaoMapa($codSolicitacao, $codEntidade, $exercicio, $codItem, $codCentro);

        return $this->formataSolicitacaoMapa($items, $exercicio, $codEntidade, $codSolicitacao);
    }

    /**
     * @param object $itemSolicitacao
     *
     * @return float
     */
    public function montaRecuperaValorReserva($itemSolicitacao)
    {
        $entityManager = $this->entityManager;

        $valorReserva = 0;

        $recuperaReservaSaldo = function ($codReserva, $exercicioReserva) use ($entityManager) {
            $reservaSaldosModel = new ReservaSaldosModel($entityManager);
            $result = $reservaSaldosModel->getValueAvaiableDotacao($codReserva, $exercicioReserva);

            return isset($result['vl_reserva']) ? $result['vl_reserva'] : 0;
        };

        if (is_numeric($itemSolicitacao->cod_reserva) && is_numeric($itemSolicitacao->exercicio_reserva)) {
            $valorReserva = $recuperaReservaSaldo($itemSolicitacao->cod_reserva, $itemSolicitacao->exercicio_reserva);
        }

        if (is_numeric($itemSolicitacao->cod_reserva_solicitacao)
            && is_numeric($itemSolicitacao->exercicio_reserva_solicitacao)
            && $itemSolicitacao->cod_reserva_solicitacao . $itemSolicitacao->exercicio_reserva_solicitacao != $itemSolicitacao->cod_reserva . $itemSolicitacao->exercicio_reserva) {
            $resultReservaSaldo = $recuperaReservaSaldo($itemSolicitacao->cod_reserva_solicitacao, $itemSolicitacao->exercicio_reserva_solicitacao);

            $valorReserva = $valorReserva + $resultReservaSaldo;
        }

        return filter_var($valorReserva, FILTER_VALIDATE_FLOAT);
    }

    /**
     * @param object $itemSolicitacao
     * @param string $exercicio
     *
     * @return float
     */
    public function montaRecuperaSaldoDisponivelDotacao($itemSolicitacao, $exercicio)
    {
        $entityManager = $this->entityManager;

        $saldoDotacao = $this->montaRecuperaSaldoAnterior($exercicio, $itemSolicitacao->cod_despesa);
        $saldoDisponivelDotacao = $saldoDotacao;

        $recuperaReservaSaldo = function ($codReserva, $exercicioReserva) use ($entityManager) {
            $reservaSaldosModel = new ReservaSaldosModel($entityManager);
            $result = $reservaSaldosModel->getValueAvaiableDotacao($codReserva, $exercicioReserva);

            return isset($result['vl_reserva']) ? $result['vl_reserva'] : 0;
        };

        if (isset($itemSolicitacao->cod_reserva) && isset($itemSolicitacao->exercicio_reserva)) {
            $valorReserva = $recuperaReservaSaldo($itemSolicitacao->cod_reserva, $itemSolicitacao->exercicio_reserva);
            $saldoDisponivelDotacao = $valorReserva + $saldoDotacao;
        }

        if (isset($itemSolicitacao->cod_reserva_solicitacao)
            && isset($itemSolicitacao->exercicio_reserva_solicitacao)
            && $itemSolicitacao->cod_reserva_solicitacao . $itemSolicitacao->exercicio_reserva_solicitacao != $itemSolicitacao->cod_reserva . $itemSolicitacao->exercicio_reserva) {
            $resultReservaSaldo = $recuperaReservaSaldo($itemSolicitacao->cod_reserva_solicitacao, $itemSolicitacao->exercicio_reserva_solicitacao);

            $saldoDisponivelDotacao = $saldoDisponivelDotacao + $resultReservaSaldo;
        }

        return $saldoDisponivelDotacao;
    }

    /**
     * @param $exercicio
     * @param $cod_mapa
     * @return mixed
     */
    public function montaRecuperaItensMapa($exercicio, $cod_mapa)
    {
        return $this->repository->montaRecuperaItensMapa($exercicio, $cod_mapa);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return array
     */
    public function montaRecuperaItensCompraDireta($codMapa, $exercicio)
    {
        return $this->repository->montaRecuperaItensCompraDireta($codMapa, $exercicio);
    }

    /**
     * @param $cod_mapa
     * @param $exercicio
     * @return mixed
     */
    public function montaRecuperaItensPropostaAgrupados($cod_mapa, $exercicio)
    {
        return $this->repository->montaRecuperaItensPropostaAgrupados($cod_mapa, $exercicio);
    }

    /**
     * @param $cod_mapa
     * @param $exercicio
     * @return mixed
     */
    public function montaRecuperaMapaCotacaoValida($cod_mapa, $exercicio)
    {
        return $this->repository->montaRecuperaMapaCotacaoValida($cod_mapa, $exercicio);
    }

    /**
     * @param MapaItem $mapaItem
     * @return MapaItem
     */
    public function montaValorReferencia(Compras\MapaItem $mapaItem)
    {
        $result = $this->repository->getValorReferencia([
            'cod_mapa' => $mapaItem->getCodMapa(),
            'exercicio' => $mapaItem->getExercicio(),
            'cod_item' => $mapaItem->getCodItem()
        ]);

        $mapaItem->vlReferencia = !empty($result) ? $result['vl_referencia'] : null;

        return $mapaItem;
    }

    /**
     * @param MapaItem $mapaItem
     * @return MapaItem
     */
    public function montaValorUltimaCompra(Compras\MapaItem $mapaItem)
    {
        /** @var CatalogoItemRepository $catalogoItemRepository */
        $catalogoItemRepository = $this->entityManager->getRepository(Almoxarifado\CatalogoItem::class);

        $result = $catalogoItemRepository->getValorUltimaCompra([
            'cod_item' => $mapaItem->getCodItem(),
            'exercicio' => $mapaItem->getExercicio()
        ]);

        $mapaItem->vlUltimaCompra = !empty($result) ? $result['vl_unitario_ultima_compra'] : null;

        return $mapaItem;
    }

    /**
     * @param Compras\MapaItem $mapaItem
     * @param Compras\Cotacao $cotacao
     * @return Compras\MapaItem
     */
    public function montaCotacaoItemReference(
        Compras\MapaItem $mapaItem,
        Compras\Cotacao $cotacao
    ) {
        $keys = [
            $mapaItem->getExercicio(),
            $cotacao->getCodCotacao(),
            $mapaItem->getLote(),
            $mapaItem->getCodItem()
        ];

        $mapaItem->cotacaoItemReference = implode('~', $keys);

        return $mapaItem;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return null|object
     */
    public function getOneMapaItem($codMapa, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codMapa' => $codMapa,
        ]);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return null|object
     */
    public function getMapaItem($codMapa, $exercicio)
    {
        return $this->repository->findBy([
            'exercicio' => $exercicio,
            'codMapa' => $codMapa,
        ]);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return mixed
     */
    public function carregaInformacoesMapa($codMapa, $exercicio)
    {
        return $this->repository->carregaInformacoesMapa($codMapa, $exercicio);
    }

    /**
     * @param $registroPrecos
     * @return ORM\QueryBuilder
     */
    public function carregaModalidade($registroPrecos)
    {
        $modalidadeRepository = $this->entityManager->getRepository(Compras\Modalidade::class);
        $queryBuilder = $modalidadeRepository->createQueryBuilder('modalidade');

        if ($registroPrecos == 'Sim') {
            $queryBuilder->where("modalidade.codModalidade IN (3,6,7)");
        } else {
            $queryBuilder->where("modalidade.codModalidade NOT IN (4,5,10,11)");
        }

        return $queryBuilder;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return mixed
     */
    public function somaValoresMapa($codMapa, $exercicio)
    {
        return $this->repository->somaValoresMapa($codMapa, $exercicio);
    }

    /**
     * @param $exercicio
     * @param $codMapa
     * @return mixed
     */
    public function getRecuperaReservas($exercicio, $codMapa)
    {
        return $this->repository->getRecuperaReservas($exercicio, $codMapa);
    }

    /**
     * @param null|string $codSolicitacao
     * @param null|string $codEntidade
     * @param null|string $exercicioSolicitacao
     * @param null|string $codItem
     * @param null|string $codCentro
     * @param null|string $codMapa
     * @param null|string $exercicioMapa
     *
     * @return mixed
     */
    public function montaRecuperaItemSolicitacaoMapa($codSolicitacao = null, $codEntidade = null, $exercicioSolicitacao = null, $codItem = null, $codCentro = null, $codMapa = null, $exercicioMapa = null)
    {
        $itens = $this->repository->montaRecuperaItemSolicitacaoMapa($codSolicitacao, $codEntidade, $exercicioSolicitacao, $codItem, $codCentro, $codMapa, $exercicioMapa);

        return $this->formataSolicitacaoMapa($itens, $exercicioSolicitacao, $codEntidade, $codSolicitacao);
    }

    /**
     * @param $exercicio
     * @param $codDespesa
     * @return mixed
     */
    public function montaRecuperaSaldoAnterior($exercicio, $codDespesa)
    {
        return filter_var($this->repository->montaRecuperaSaldoAnterior($exercicio, $codDespesa), FILTER_VALIDATE_FLOAT);
    }

    /**
     * @param $codItem
     * @param $exercicio
     * @return mixed
     */
    public function montaRecuperaValorItemUltimaCompra($codItem, $exercicio)
    {
        return $this->repository->montaRecuperaValorItemUltimaCompra($codItem, $exercicio);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return mixed
     */
    public function montaRecuperaMapaSolicitacoes($codMapa, $exercicio)
    {
        return $this->repository->montaRecuperaMapaSolicitacoes($codMapa, $exercicio);
    }

    /**
     * @param $codSolicitacao
     * @param $codEntidade
     * @param $exercicioSolicitacao
     * @param $codItem
     * @param $codCentro
     * @param $codMapa
     * @param $exercicio
     * @param $cod_despesa
     * @param $cod_conta
     * @return array
     */
    public function montaRecuperaQtdeAtendidaEmMapas($codSolicitacao, $codEntidade, $exercicioSolicitacao, $codItem, $codCentro, $codMapa = null, $exercicio = null, $cod_despesa = null, $cod_conta = null)
    {
        return $this->repository->montaRecuperaQtdeAtendidaEmMapas($codSolicitacao, $codEntidade, $exercicioSolicitacao, $codItem, $codCentro, $codMapa, $exercicio, $cod_despesa, $cod_conta);
    }
}
