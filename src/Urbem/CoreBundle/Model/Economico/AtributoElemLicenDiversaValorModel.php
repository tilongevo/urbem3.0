<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor;

/**
 * Class AtributoElemLicenDiversaValorModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class AtributoElemLicenDiversaValorModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * AtributoElemLicenDiversaValorModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(AtributoElemLicenDiversaValor::class);
    }
}
