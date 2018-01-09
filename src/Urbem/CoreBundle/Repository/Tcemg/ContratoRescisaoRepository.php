<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ContratoRescisaoFilter;

class ContratoRescisaoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(ContratoRescisaoFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(ContratoRescisao)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param ContratoRescisaoFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(ContratoRescisaoFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ContratoRescisaoFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(ContratoRescisaoFilter $filter)
    {
        $qb = $this->createQueryBuilder('ContratoRescisao');
        $qb->join('ContratoRescisao.fkTcemgContrato', 'fkTcemgContrato');

        if (null !== $filter->getNroContrato()) {
            $qb->andWhere('fkTcemgContrato.nroContrato = :nroContrato');
            $qb->setParameter('nroContrato', $filter->getNroContrato());
        }

        if (null !== $filter->getDataPublicacao()) {
            $qb->andWhere('fkTcemgContrato.dataPublicacao >= :dataPublicacao');
            $qb->setParameter('dataPublicacao', $filter->getDataPublicacao());
        }

        if (null !== $filter->getDataRescisao()) {
            $qb->andWhere('ContratoRescisao.dataRescisao >= :dataRescisao');
            $qb->setParameter('dataRescisao', $filter->getDataRescisao());
        }

        if (null !== $filter->getPeriodicidadeInicio()) {
            $qb->andWhere('fkTcemgContrato.dataInicio >= :periodicidadeInicio');
            $qb->setParameter('periodicidadeInicio', $filter->getPeriodicidadeInicio());
        }

        if (null !== $filter->getPeriodicidadeFim()) {
            $qb->andWhere('fkTcemgContrato.dataFinal <= :periodicidadeFim');
            $qb->setParameter('periodicidadeFim', $filter->getPeriodicidadeFim());
        }

        if (null !== $filter->getObjetoContrato()) {
            $qb->andWhere($qb->expr()->like('fkTcemgContrato.objetoContrato', $qb->expr()->literal(sprintf('%%%s%%', $filter->getObjetoContrato()))));
        }

        $qb->addOrderBy('fkTcemgContrato.codEntidade', 'DESC');
        $qb->addOrderBy('fkTcemgContrato.exercicio', 'DESC');
        $qb->addOrderBy('fkTcemgContrato.nroContrato', 'DESC');

        return $qb;
    }
}
