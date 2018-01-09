<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\NotaFiscalFilter;

class NotaFiscalRepository extends AbstractRepository
{
    public function getNextCodNota()
    {
        return $this->nextVal('cod_nota');
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(NotaFiscalFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(NotaFiscal)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param NotaFiscalFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(NotaFiscalFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param NotaFiscalFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(NotaFiscalFilter $filter)
    {
        $qb = $this->createQueryBuilder('NotaFiscal');

        if (null !== $filter->getNumNota()) {
            $qb->andWhere('NotaFiscal.nroNota = :nroNota');
            $qb->setParameter('nroNota', $filter->getNumNota());
        }

        if (null !== $filter->getNumSerie()) {
            $qb->andWhere('NotaFiscal.nroNota = :nroSerie');
            $qb->setParameter('nroSerie', $filter->getNumSerie());
        }

        if (null !== $filter->getExercicioNota()) {
            $qb->andWhere('NotaFiscal.exercicio = :exercicioNota');
            $qb->setParameter('exercicio', $filter->getExercicioNota());
        }

        if (null !== $filter->getDtEmissao()) {
            $qb->andWhere('NotaFiscal.dataEmissao = :dataEmissao');
            $qb->setParameter('dataEmissao', $filter->getDtEmissao());
        }

        if (null !== $filter->getExercicioEmpenho()) {
            $qb->join('NotaFiscal.fkTcemgNotaFiscalEmpenhoLiquidacoes', 'fkTcemgNotaFiscalEmpenhoLiquidacoes');
            $qb->andWhere('fkTcemgNotaFiscalEmpenhoLiquidacoes.exercicioEmpenho = :exercicioEmpenho');
            $qb->setParameter('exercicioEmpenho', $filter->getExercicioEmpenho());
        }

        if (null !== $filter->getEmpenho()) {
            $qb->join('NotaFiscal.fkTcemgNotaFiscalEmpenhos', 'fkTcemgNotaFiscalEmpenhos');
            $qb->join('fkTcemgNotaFiscalEmpenhos.fkEmpenhoEmpenho', 'fkEmpenhoEmpenho');
            $qb->andWhere('fkEmpenhoEmpenho.codEmpenho = :fkEmpenhoEmpenho_codEmpenho');
            $qb->andWhere('fkEmpenhoEmpenho.exercicio = :fkEmpenhoEmpenho_exercicio');
            $qb->andWhere('fkEmpenhoEmpenho.codEntidade = :fkEmpenhoEmpenho_codEntidade');

            $qb->setParameter('fkEmpenhoEmpenho_codEmpenho', $filter->getEmpenho()->getCodEmpenho());
            $qb->setParameter('fkEmpenhoEmpenho_exercicio', $filter->getEmpenho()->getExercicio());
            $qb->setParameter('fkEmpenhoEmpenho_codEntidade', $filter->getEmpenho()->getCodEntidade());
        }

        if (null !== $filter->getEntidade()) {
            $qb->join('NotaFiscal.fkOrcamentoEntidade', 'fkOrcamentoEntidade');
            $qb->andWhere('fkOrcamentoEntidade.exercicio = :fkOrcamentoEntidade_exercicio');
            $qb->andWhere('fkOrcamentoEntidade.codEntidade = :fkOrcamentoEntidade_codEntidade');

            $qb->setParameter('fkOrcamentoEntidade_exercicio', $filter->getEntidade()->getExercicio());
            $qb->setParameter('fkOrcamentoEntidade_codEntidade', $filter->getEntidade()->getCodEntidade());
        }

        return $qb;
    }
}
