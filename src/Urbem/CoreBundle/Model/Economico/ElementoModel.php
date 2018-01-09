<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\Elemento;

/**
 * Class ElementoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class ElementoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * ElementoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Elemento::class);
    }

    /**
     * @param $codElemento
     * @return mixed
     */
    public function getElemento($codElemento)
    {
        return $this->repository->findByCodElemento($codElemento);
    }

    /**
     * @param $codElemento
     * @return mixed
     */
    public function getOneElemento($codElemento)
    {
        return $this->repository->findOneByCodElemento($codElemento);
    }

    /**
     * @return array
     */
    public function getElementoAll()
    {
        return $this->repository->findAll();
    }
}
