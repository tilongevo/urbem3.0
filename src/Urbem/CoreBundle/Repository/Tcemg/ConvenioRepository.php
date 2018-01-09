<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ConvenioFilter;

class ConvenioRepository extends AbstractRepository
{
    public function getNextCodConvenio()
    {
        return $this->nextVal('cod_convenio');
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(ConvenioFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(Convenio)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param ConvenioFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(ConvenioFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ConvenioFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(ConvenioFilter $filter)
    {
        $qb = $this->createQueryBuilder('Convenio');

        if (null !== $filter->getExercicio()) {
            $qb->andWhere('Convenio.exercicio = :exercicio');
            $qb->setParameter('exercicio', $filter->getExercicio());
        }

        if (null !== $filter->getEntidade()) {
            $qb->join('Convenio.fkOrcamentoEntidade', 'fkOrcamentoEntidade');
            $qb->andWhere('fkOrcamentoEntidade.exercicio = :fkOrcamentoEntidade_exercicio');
            $qb->andWhere('fkOrcamentoEntidade.codEntidade = :fkOrcamentoEntidade_codEntidade');

            $qb->setParameter('fkOrcamentoEntidade_exercicio', $filter->getEntidade()->getExercicio());
            $qb->setParameter('fkOrcamentoEntidade_codEntidade', $filter->getEntidade()->getCodEntidade());
        }

        if (null !== $filter->getNumConvenio()) {
            $qb->andWhere('Convenio.codConvenio = :codConvenio');
            $qb->setParameter('codConvenio', $filter->getNumConvenio());
        }

        if (null !== $filter->getPeriodicidadeInicio()) {
            $qb->andWhere('Convenio.dataInicio >= :periodicidadeInicio');
            $qb->setParameter('periodicidadeInicio', $filter->getPeriodicidadeInicio());
        }

        if (null !== $filter->getPeriodicidadeFim()) {
            $qb->andWhere('Convenio.dataFinal <= :periodicidadeFim');
            $qb->setParameter('periodicidadeFim', $filter->getPeriodicidadeFim());
        }

        return $qb;
    }
}
