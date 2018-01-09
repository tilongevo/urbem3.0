<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ConfigurarIdeRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class ConfigurarIdeRepository extends AbstractRepository
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
