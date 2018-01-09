<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class TransferenciaAlmoxarifadoItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class TransferenciaAlmoxarifadoItemModel extends Model
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * TransferenciaAlmoxarifadoItemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\TransferenciaAlmoxarifadoItem::class);
    }

    /**
     * Constroi e persiste uma Entity de TransferenciaAlmoxarifadoItem com base em PedidoTransferenciaItem
     *
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     * @param Almoxarifado\LancamentoMaterial $lancamentoMaterial
     * @return Almoxarifado\TransferenciaAlmoxarifadoItem
     */
    public function buildOneBasedPedidoTransferenciaItem(
        Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem,
        Almoxarifado\LancamentoMaterial $lancamentoMaterial
    ) {

        $transferenciaAlmoxarifadoItem = new Almoxarifado\TransferenciaAlmoxarifadoItem();
        $transferenciaAlmoxarifadoItem->setFkAlmoxarifadoPedidoTransferenciaItem($pedidoTransferenciaItem);
        $transferenciaAlmoxarifadoItem->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);

        $this->save($transferenciaAlmoxarifadoItem);

        return $transferenciaAlmoxarifadoItem;
    }
}
