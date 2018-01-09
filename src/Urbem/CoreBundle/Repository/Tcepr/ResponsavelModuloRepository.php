<?php

namespace Urbem\CoreBundle\Repository\Tcepr;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter\ResponsavelModuloFilter;

class ResponsavelModuloRepository extends AbstractRepository
{
    public function getNextCodResponsavel()
    {
        return $this->nextVal('cod_responsavel');
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(ResponsavelModuloFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(ResponsavelModulo)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param ResponsavelModuloFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(ResponsavelModuloFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ResponsavelModuloFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(ResponsavelModuloFilter $filter)
    {
        $qb = $this->createQueryBuilder('ResponsavelModulo');

        if (null !== $filter->getFkTceprTipoModulo()) {
            $qb->join('ResponsavelModulo.fkTceprTipoModulo', 'TipoModulo');
            $qb->andWhere('TipoModulo.idTipoModulo = :idTipoModulo');
            $qb->setParameter('idTipoModulo', $filter->getFkTceprTipoModulo()->getIdTipoModulo());
        }

        return $qb;
    }
}
