<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ConfiguracaoReglicRepository
 * @package Urbem\CoreBundle\Repository\Tcemg */
class ConfiguracaoReglicRepository extends AbstractRepository
{
    /**
     * @param $entidade
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByEntidadeAndExercicio($entidade, $exercicio)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.codEntidade = :entidade')
            ->andWhere('r.exercicio = :exercicio')
            ->setParameter('entidade', $entidade)
            ->setParameter('exercicio', $exercicio);

        return $qb;
    }
}