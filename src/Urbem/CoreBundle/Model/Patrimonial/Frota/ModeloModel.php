<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;

/**
 * Class ModeloModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class ModeloModel implements Model\InterfaceModel
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
        $this->repository = $this->entityManager->getRepository(Entity\Frota\Modelo::class);
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        // Implements canRemove
    }

    /**
     * Pega o próximo identificador disponível
     *
     * @param int $codMarca
     * @return int identifier
     */
    public function getAvailableIdentifier($codMarca)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select(
                $queryBuilder->expr()->max("o.codModelo") . " AS identifier"
            )
            ->from(Entity\Frota\Modelo::class, 'o')
            ->where('o.codMarca = '.$codMarca)
        ;
        $result = $queryBuilder->getQuery()->getSingleResult();
        $lastCodModelo = $result["identifier"] + 1;
        return $lastCodModelo;
    }

    /**
     * @param array $params
     * @return array|Entity\Frota\Modelo[]
     */
    public function findBy($params)
    {
        return $this->repository->findBy($params);
    }

    /**
     * @param array $params
     * @return Entity\Frota\Modelo
     */
    public function findOneBy($params)
    {
        return $this->repository->findOneBy($params);
    }
}
