<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;

use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class PedidoTransferenciaItemDestinoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class PedidoTransferenciaItemDestinoModel
{
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null  */
    protected $repository = null;

    /**
     * PedidoTransferenciaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository(Almoxarifado\PedidoTransferenciaItemDestino::class);
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     * @param Almoxarifado\CentroCusto $centroCusto
     * @return Almoxarifado\PedidoTransferenciaItemDestino
     */
    public function buildBasedPedidoTransferenciaItemCentroCusto(
        Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem,
        Almoxarifado\CentroCusto $centroCusto
    ) {
        $pedidoTransferenciaItemDestino = new Almoxarifado\PedidoTransferenciaItemDestino();
        $pedidoTransferenciaItemDestino->setFkAlmoxarifadoPedidoTransferenciaItem($pedidoTransferenciaItem);
        $pedidoTransferenciaItemDestino->setFkAlmoxarifadoCentroCusto($centroCusto);

        return $pedidoTransferenciaItemDestino;
    }
}
