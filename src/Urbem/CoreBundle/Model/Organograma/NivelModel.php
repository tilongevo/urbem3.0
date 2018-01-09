<?php

namespace Urbem\CoreBundle\Model\Organograma;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Organograma\Nivel;
use Urbem\CoreBundle\Entity\Organograma\Organograma;

class NivelModel extends AbstractModel
{
    /** @var EntityRepository $repository */
    protected $repository;

    /**
     * OrgaoNivelModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Nivel::class);
    }

    /**
     * @param Organograma $organograma
     *
     * @return null|Nivel|ArrayCollection
     */
    public function findByOrganograma(Organograma $organograma)
    {
        $niveis = $this->repository->findBy([
            'fkOrganogramaOrganograma' => $organograma
        ]);

        return new ArrayCollection($niveis);
    }
}
