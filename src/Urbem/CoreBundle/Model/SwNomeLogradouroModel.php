<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwNomeLogradouro;
use Urbem\CoreBundle\Entity\SwTipoLogradouro;

/**
 * Class SwNomeLogradouroModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwNomeLogradouroModel extends AbstractModel implements InterfaceModel
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SwNomeLogradouro::class);
    }

    /**
     * {@inheritdoc}
     */
    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    public function buildOne(SwLogradouro $swLogradouro, SwTipoLogradouro $swTipoLogradouro)
    {
    }
}
