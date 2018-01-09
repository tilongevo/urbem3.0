<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\DDCFilter;

class ConfiguracaoDdcRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(DDCFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(ConfiguracaoDdc)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param DDCFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(DDCFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param DDCFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(DDCFilter $filter)
    {
        $qb = $this->createQueryBuilder('ConfiguracaoDdc');

        if (null !== $filter->getEntidade()) {
            $qb->andWhere('ConfiguracaoDdc.codEntidade = :entidade_codEntidade');
            $qb->andWhere('ConfiguracaoDdc.exercicio = :entidade_exercicio');

            $qb->setParameter('entidade_codEntidade', $filter->getEntidade()->getCodEntidade());
            $qb->setParameter('entidade_exercicio', $filter->getEntidade()->getExercicio());
        }

        if (null !== $filter->getExercicio()) {
            $qb->andWhere('ConfiguracaoDdc.exercicio = :exercicio');

            $qb->setParameter('exercicio', $filter->getExercicio());
        }

        if (null !== $filter->getMes()) {
            $qb->andWhere('ConfiguracaoDdc.mesReferencia = :mesReferencia');

            $qb->setParameter('mesReferencia', $filter->getMes());
        }

        return $qb;
    }
}
