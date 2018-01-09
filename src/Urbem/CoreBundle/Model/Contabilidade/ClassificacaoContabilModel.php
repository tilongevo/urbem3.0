<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class ClassificacaoContabilModel extends AbstractModel implements Model\InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\ClassificacaoContabil");
    }

    public function canRemove($object)
    {
        $planoContaRepository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\PlanoConta");
        $resultPlanoConta = $planoContaRepository
            ->findOneBy(['codClassificacao' => $object->getCodClassificacao(), 'exercicio' => $object->getExercicio()]);

        return is_null($resultPlanoConta);
    }

    public function replicarClassificacaoContabeis($exercicio)
    {
        $qb = $this->repository->createQueryBuilder('cc');
        $qb->select('COUNT(cc)');
        $qb->andWhere('cc.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        if (0 < $qb->getQuery()->getSingleScalarResult()) {
            return;
        }

        $maxDQL = $this->repository->createQueryBuilder('ccm');
        $maxDQL->select('MAX(ccm.exercicio)');

        $qb = $this->repository->createQueryBuilder('cc');
        $qb->groupBy('cc.codClassificacao, cc.exercicio');
        $qb->andWhere('cc.exercicio = (' . $maxDQL->getDQL() . ')');

        foreach ($qb->getQuery()->getResult() as $classificacaoContabil) {
            $classificacaoContabil = clone $classificacaoContabil;
            $classificacaoContabil->setExercicio($exercicio);

            $this->entityManager->persist($classificacaoContabil);
        }

        $this->entityManager->flush();
    }
}
