<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Ctps;

/**
 * Class CtpsModel
 * @package Urbem\CoreBundle\Model\Pessoal
 */
class CtpsModel extends AbstractModel
{
    /**
     * @var EntityManager|null
     */
    protected $entityManager = null;
    /**
     * @var \Doctrine\ORM\EntityRepository|null|\Urbem\CoreBundle\Repository\Pessoal\CtpsRepository
     */
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Ctps::class);
    }

    /**
     * @return int
     */
    public function getNextCtpsCode()
    {
        return $this->repository->getNextCtpsCode();
    }
}
