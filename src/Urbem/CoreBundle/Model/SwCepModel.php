<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwCep;

/**
 * Class SwCepModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwCepModel extends AbstractModel implements InterfaceModel
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
        $this->repository = $entityManager->getRepository(SwCep::class);
    }

    /**
     * {@inheritdoc}
     */
    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * @param string $cep
     * @param string $cepAnterior
     *
     * @return SwCep
     */
    public function buidOne($cep, $cepAnterior = null)
    {
        $swCep = new SwCep();
        $swCep->setCep($cep);
        $swCep->setCepAnterior($cepAnterior);

        return $swCep;
    }
}
