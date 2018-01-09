<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;

/**
 * Class CombustivelModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class CombustivelModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    /**
     * MarcaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {

        /** @var ORM\EntityManager entityManager */
        $this->entityManager = $entityManager;
        /** @var ORM\EntityRepository repository */
        $this->repository = $this->entityManager->getRepository(Entity\Frota\Combustivel::class);
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        # Implements canRemove
    }

    /**
     * @param array $params['codCombustivel']
     * @return Entity\Frota\Combustivel
     */
    public function findOneBy($params)
    {
        return $this->repository
            ->findOneBy($params);
    }
}
