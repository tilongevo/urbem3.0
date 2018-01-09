<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Patrimonio\ReavaliacaoRepository;

/**
 * Class ReavaliacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Patrimonio
 */
class ReavaliacaoModel implements Model\InterfaceModel
{
    /** @var ORM\EntityManager|null $entityManager */
    private $entityManager = null;
    /** @var ReavaliacaoRepository|null $repository */
    protected $repository = null;

    /**
     * ReavaliacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\Reavaliacao");
    }

    /**
     * @param $object
     */
    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * @param $codBem
     * @return int
     */
    public function getProximoCodReavaliacao($codBem)
    {
        return $this->repository->getProximoCodReavaliacao($codBem);
    }
}
