<?php

namespace Urbem\CoreBundle\Model\Normas;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Normas\NormaDataTermino;

/**
 * Class NormaDataTerminoModel
 *
 * @package Urbem\CoreBundle\Model\Normas
 */
class NormaDataTerminoModel extends AbstractModel
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * NormaDataTerminoModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(NormaDataTermino::class);
    }

    /**
     * @param Norma     $norma
     * @param \DateTime $dtTermino
     *
     * @return NormaDataTermino
     */
    public function buildOne(Norma $norma, \DateTime $dtTermino)
    {
        $normaDataTermino = new NormaDataTermino();
        $normaDataTermino->setFkNormasNorma($norma);
        $normaDataTermino->setDtTermino($dtTermino);

        $this->save($normaDataTermino);

        return $normaDataTermino;
    }

    /**
     * @param NormaDataTermino $normaDataTermino
     * @param \DateTime        $dtTermino
     *
     * @return NormaDataTermino
     */
    public function updateOne(NormaDataTermino $normaDataTermino, \DateTime $dtTermino)
    {
        $normaDataTermino->setDtTermino($dtTermino);

        $this->save($normaDataTermino);

        return $normaDataTermino;
    }
}
