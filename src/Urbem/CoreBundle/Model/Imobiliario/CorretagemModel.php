<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Imobiliario\Corretagem;
use Urbem\CoreBundle\Repository\Imobiliario\CorretagemRepository;

/**
 * Class CorretagemModel
 * @package Urbem\CoreBundle\Model\Imobiliario
 */
class CorretagemModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var CorretagemRepository|null
     */
    protected $repository = null;

    /**
     * CorretagemModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Corretagem::class);
    }

    /**
     * @param $creci
     */
    public function getCorretagem($creci)
    {
        $repository = $this->repository;
        return $repository->findOneByCreci($creci);
    }

    /**
     * @param $params
     * @return array
     */
    public function getCorretagemReport($params)
    {
        return $this->repository->getCorretagemReport($params);
    }
}
