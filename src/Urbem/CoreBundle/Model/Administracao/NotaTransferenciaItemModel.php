<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\AbstractModel;
use Doctrine\DBAL\Query\QueryBuilder;
use Urbem\PatrimonialBundle\Controller\Almoxarifado\NotaTransferenciaItemController;

/**
 * Class NotaTransferenciaItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class NotaTransferenciaItemModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * OrdemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(PedidoTransferenciaItem::class);
    }

    /**
     * @param $exercicio
     * @param string $params
     * @param string $limit
     * @return array
     */
    public function getEmpenhosAtivos($exercicio, $params = '', $limit = '')
    {
        return $this->repository->getEmpenhosAtivos($exercicio, $params, $limit);
    }
}
