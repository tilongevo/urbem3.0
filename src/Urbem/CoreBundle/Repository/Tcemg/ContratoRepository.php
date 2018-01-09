<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ContratoFilter;

class ContratoRepository extends AbstractRepository
{
    public function getNextCodContrato()
    {
        return $this->nextVal('cod_contrato');
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(ContratoFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(Contrato)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param ContratoFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(ContratoFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ContratoFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(ContratoFilter $filter)
    {
        $qb = $this->createQueryBuilder('Contrato');

        $hasFilter = false;

        if (null !== $filter->getNroContrato()) {
            $hasFilter = true;

            $qb->andWhere('Contrato.nroContrato = :nroContrato');
            $qb->setParameter('nroContrato', $filter->getNroContrato());
        }

        if (null !== $filter->getDataPublicacao()) {
            $hasFilter = true;

            $qb->andWhere('Contrato.dataPublicacao >= :dataPublicacao');
            $qb->setParameter('dataPublicacao', $filter->getDataPublicacao());
        }

        if (null !== $filter->getPeriodicidadeInicio()) {
            $hasFilter = true;

            $qb->andWhere('Contrato.dataInicio >= :periodicidadeInicio');
            $qb->setParameter('periodicidadeInicio', $filter->getPeriodicidadeInicio());
        }

        if (null !== $filter->getPeriodicidadeFim()) {
            $hasFilter = true;

            $qb->andWhere('Contrato.dataFinal <= :periodicidadeFim');
            $qb->setParameter('periodicidadeFim', $filter->getPeriodicidadeFim());
        }

        if (null !== $filter->getObjetoContrato()) {
            $hasFilter = true;

            $qb->andWhere($qb->expr()->like('Contrato.objetoContrato', $qb->expr()->literal(sprintf('%%%s%%', $filter->getObjetoContrato()))));
        }

        if (true === $hasFilter) {
            $qb->leftJoin('Contrato.fkTcemgContratoRescisao', 'fkTcemgContratoRescisao');
            $qb->andWhere('fkTcemgContratoRescisao.codContrato IS NULL');
        }

        return $qb;
    }

    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('Contrato');

        $orx = $qb->expr()->orX();

        $orx->add($qb->expr()->like('string(Contrato.nroContrato)', ':term'));
        $orx->add($qb->expr()->like('string(Contrato.codContrato)', ':term'));
        $orx->add($qb->expr()->like('string(Contrato.objetoContrato)', ':term'));

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', $term));

        $qb->orderBy('Contrato.codContrato');
        $qb->setMaxResults(10);

        return $qb;
    }
}
