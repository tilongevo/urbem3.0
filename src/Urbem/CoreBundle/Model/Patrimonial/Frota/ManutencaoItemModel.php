<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Entity\Frota\Item;
use Urbem\CoreBundle\Entity\Frota\Manutencao;
use Urbem\CoreBundle\Entity\Frota\ManutencaoItem;
use Urbem\CoreBundle\Model\Folhapagamento\BasesModel;
use Urbem\CoreBundle\Model\InterfaceModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoMaterialModel;
use Urbem\CoreBundle\Repository\Patrimonio\Frota\ManutencaoRepository;

/**
 * Class ManutencaoItemModel
 */
class ManutencaoItemModel extends BasesModel implements InterfaceModel
{
    protected $entityManager = null;

    /** @var ManutencaoRepository $repository */
    protected $repository = null;

    /**
     * ManutencaoItemModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Frota\ManutencaoItem::class);
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * @deprecated
     * @param Frota\Manutencao $manutencao
     * @param Almoxarifado\LancamentoRequisicao $lancamentoRequisicao
     * @return ManutencaoItem
     */
    public function buildManutencaoItemByManutencao(
        Frota\Manutencao $manutencao,
        Almoxarifado\LancamentoRequisicao $lancamentoRequisicao
    ) {
    

        $catalogoItem = $lancamentoRequisicao->getCodItem();
        $quantidade = $lancamentoRequisicao->getFkAlmoxarifadoRequisicaoItem()->getQuantidade();


        $lancamentoMaterialModel = new LancamentoMaterialModel($this->entityManager);
        $valorUnitario = $lancamentoMaterialModel->getSaldoValorUnitarioRequisicao($lancamentoRequisicao, true);
        $valorUnitario *= $lancamentoRequisicao->getFkAlmoxarifadoRequisicaoItem()->getQuantidade();
        $valorUnitario += $lancamentoMaterialModel->getRecuperaRestoValorUnitario($lancamentoRequisicao);

        $frotaItem = $this->entityManager
            ->getRepository(Frota\Item::class)
            ->find($catalogoItem);

        $manutencaoItem = new Frota\ManutencaoItem();
        $manutencaoItem->setFkFrotaItem($frotaItem);
        $manutencaoItem->setQuantidade($quantidade);
        $manutencaoItem->setValor($valorUnitario);

        $manutencao->addFkFrotaManutencaoItens($manutencaoItem);

        return $manutencaoItem;
    }

    /**
     * @deprecated Use buildOne(Manutencao $manutencao, Item $item, $quantidade, $valor) instead.
     * @param Frota\Manutencao  $manutencao
     * @param Frota\Item        $item
     * @param string            $quantidadeSaida
     * @return ManutencaoItem
     */
    public function buildManutencaoItem(
        Frota\Manutencao $manutencao,
        Frota\Item $item,
        $quantidadeSaida
    ) {
        $lancamentoMaterialModel = new LancamentoMaterialModel($this->entityManager);
        $saldoValorUnitario = $lancamentoMaterialModel->getSaldoValorUnitario($item);
        $restoValor = $lancamentoMaterialModel->getRestoValor($item);

        $valorUnitario = abs(($saldoValorUnitario * $quantidadeSaida) + $restoValor);

        return $this->buildOne($manutencao, $item, $quantidadeSaida, $valorUnitario);
    }

    /**
     * @param Manutencao $manutencao
     * @param Item $item
     * @param $quantidade
     * @param $valor
     * @return ManutencaoItem
     */
    public function buildOne(Manutencao $manutencao, Item $item, $quantidade, $valor)
    {
        $manutencaoItem = new ManutencaoItem();

        $manutencaoItem->setFkFrotaItem($item);
        $manutencaoItem->setFkFrotaManutencao($manutencao);
        $manutencaoItem->setQuantidade($quantidade);
        $manutencaoItem->setValor($valor);

        $this->save($manutencaoItem);

        return $manutencaoItem;
    }
}
