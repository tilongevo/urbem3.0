<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwAtributoCgm;

/**
 * Class SwAtributoCgmModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwAtributoCgmModel extends AbstractModel implements InterfaceModel
{
    /** @var EntityManager  */
    protected $entityManager = null;

    /** @var EntityRepository */
    protected $repository = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SwAtributoCgm::class);
    }

    /**
     * @return array|Collection
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param SwAtributoCgm $swAtributoCgm
     *
     * @return bool
     */
    public function canRemove($swAtributoCgm)
    {
        if (!$swAtributoCgm->getFkSwCgmAtributoValores()->isEmpty()) {
            return false;
        }

        return true;
    }
}
