<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class BaixaNaturezaJuridicaModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class BaixaNaturezaJuridicaModel extends AbstractModel
{

    protected $entityManager = null;
    protected $repository = null;

    /**
     * BaixaNaturezaJuridicaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Economico\\BaixaNaturezaJuridica");
    }

    /**
     * @param $codNatureza
     * @return null|object
     */
    public function getBaixaNaturezaJuridica($codNatureza)
    {
        return $this->repository->findOneBy(['codNatureza' => $codNatureza]);
    }
}
