<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class SistemaContabilModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\SistemaContabil");
    }

    public function canRemove($object)
    {
        return true;
    }

    public function replicarSistemaContabeis($exercicio)
    {
        $qb = $this->repository->createQueryBuilder('sc');
        $qb->select('COUNT(sc)');
        $qb->andWhere('sc.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        if (0 < $qb->getQuery()->getSingleScalarResult()) {
            return;
        }

        $maxDQL = $this->repository->createQueryBuilder('scm');
        $maxDQL->select('MAX(scm.exercicio)');

        $qb = $this->repository->createQueryBuilder('sc');
        $qb->groupBy('sc.codSistema, sc.nomSistema, sc.exercicio');
        $qb->andWhere('sc.exercicio = (' . $maxDQL->getDQL() . ')');

        foreach ($qb->getQuery()->getResult() as $sistemaContabil) {
            $sistemaContabil = clone $sistemaContabil;
            $sistemaContabil->setExercicio($exercicio);

            $this->entityManager->persist($sistemaContabil);
        }

        $this->entityManager->flush();
    }
}
