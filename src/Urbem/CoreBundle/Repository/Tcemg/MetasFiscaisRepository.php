<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class MetasFiscaisRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class MetasFiscaisRepository extends AbstractRepository
{
    /**
     * @param string $exercicio
     * @return array
     */
    public function findByExercicio($exercicio)
    {
        $qb = $this->createQueryBuilder('m');
        $result = $qb->where('m.exercicio = :exercicio')
            ->setParameter('exercicio', $exercicio)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
