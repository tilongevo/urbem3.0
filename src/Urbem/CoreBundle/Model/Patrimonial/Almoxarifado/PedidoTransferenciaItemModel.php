<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\PedidoTransferenciaItemRepository;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class PedidoTransferenciaItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class PedidoTransferenciaItemModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var PedidoTransferenciaItemRepository|null  */
    protected $repository = null;

    /**
     * PedidoTransferenciaItemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository(Almoxarifado\PedidoTransferenciaItem::class);
    }

    /**
     * @param $object
     * @param $params
     * @return mixed
     */
    public function getItemByCodTransferencia($object, $params = '')
    {
        return $this->repository->getItemByCodTransferencia($object, $params);
    }

    /**
     * @param $numCgm
     * @param $codItem
     * @param $codAlmoxarifado
     * @return mixed
     */
    public function getCentroCustoDestino($numCgm, $codItem, $codAlmoxarifado)
    {
        return $this->repository->getCentroCustoDestino($numCgm, $codItem, $codAlmoxarifado);
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     * @return Almoxarifado\PedidoTransferenciaItem
     */
    public function getSaldoOrigem(Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem)
    {
        $codAlmoxarifado =
            $pedidoTransferenciaItem->getFkAlmoxarifadoPedidoTransferencia()->getCodAlmoxarifadoOrigem();

        $res = $this->repository->recuperaSaldoEmEstoque([
            'cod_item' => $pedidoTransferenciaItem->getCodItem(),
            'cod_centro' => $pedidoTransferenciaItem->getCodCentro(),
            'cod_almoxarifado' => $codAlmoxarifado
        ]);

        $pedidoTransferenciaItem->saldoAtual = $res['saldo_estoque'];

        return $pedidoTransferenciaItem;
    }
}
