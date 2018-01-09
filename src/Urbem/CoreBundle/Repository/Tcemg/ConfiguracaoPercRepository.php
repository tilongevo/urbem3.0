<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ConfiguracaoPercRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class ConfiguracaoPercRepository extends AbstractRepository
{
    /**
     * @param string $exercicio
     * @return array
     */
    public function findByExercicio($exercicio)
    {
        $qb = $this->createQueryBuilder('c');
        $result = $qb->where('c.exercicio = :exercicio')
            ->setParameter('exercicio', $exercicio)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
