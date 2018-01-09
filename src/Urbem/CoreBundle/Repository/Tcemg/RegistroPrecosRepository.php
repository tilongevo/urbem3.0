<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\RegistroPrecosFilter;

class RegistroPrecosRepository extends AbstractRepository
{
    public function getNextCodRegistroPrecos()
    {
        return $this->nextVal('cod_contrato');
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(RegistroPrecosFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(RegistroPrecos)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param RegistroPrecosFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(RegistroPrecosFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/classes/mapeamento/TTCEMGRegistroPrecos.class.php:89
     *
     * @param RegistroPrecosFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(RegistroPrecosFilter $filter)
    {
        $qb = $this->createQueryBuilder('RegistroPrecos');
        $qb->join('RegistroPrecos.fkOrcamentoEntidade', 'fkOrcamentoEntidade');
        $qb->join('RegistroPrecos.fkTcemgEmpenhoRegistroPrecos', 'EmpenhoRegistroPrecos');
        $qb->join('EmpenhoRegistroPrecos.fkEmpenhoEmpenho', 'fkEmpenhoEmpenho');
        $qb->join('RegistroPrecos.fkTcemgRegistroPrecosLicitacoes', 'fkTcemgRegistroPrecosLicitacoes');
        $qb->join('fkTcemgRegistroPrecosLicitacoes.fkLicitacaoLicitacao', 'fkLicitacaoLicitacao');

        if (null !== $filter->getEntidade()) {
            $qb->andWhere('fkOrcamentoEntidade.exercicio = :fkOrcamentoEntidade_exercicio');
            $qb->andWhere('fkOrcamentoEntidade.codEntidade = :fkOrcamentoEntidade_codEntidade');
            $qb->setParameter('fkOrcamentoEntidade_exercicio', $filter->getEntidade()->getExercicio());
            $qb->setParameter('fkOrcamentoEntidade_codEntidade', $filter->getEntidade()->getCodEntidade());
        }

        if (null !== $filter->getNumeroRegistroPrecos()) {
            $qb->andWhere('RegistroPrecos.numeroRegistroPrecos = :numeroRegistroPrecos');
            $qb->setParameter('numeroRegistroPrecos', $filter->getNumeroRegistroPrecos());
        }

        if (null !== $filter->getLicitacao()) {
            $qb->andWhere('fkLicitacaoLicitacao.codLicitacao = :fkLicitacaoLicitacao_codLicitacao');
            $qb->andWhere('fkLicitacaoLicitacao.codModalidade = :fkLicitacaoLicitacao_codModalidade');
            $qb->andWhere('fkLicitacaoLicitacao.codEntidade = :fkLicitacaoLicitacao_codEntidade');
            $qb->andWhere('fkLicitacaoLicitacao.exercicio = :fkLicitacaoLicitacao_exercicio');
            $qb->setParameter('fkLicitacaoLicitacao_codLicitacao', $filter->getLicitacao()->getCodLicitacao());
            $qb->setParameter('fkLicitacaoLicitacao_codModalidade', $filter->getLicitacao()->getCodModalidade());
            $qb->setParameter('fkLicitacaoLicitacao_codEntidade', $filter->getLicitacao()->getCodEntidade());
            $qb->setParameter('fkLicitacaoLicitacao_exercicio', $filter->getLicitacao()->getExercicio());
        }

        if (null !== $filter->getModalidade()) {
            $qb->andWhere('fkTcemgRegistroPrecosLicitacoes.codModalidade = :codModalidade');
            $qb->setParameter('codModalidade', $filter->getModalidade()->getCodModalidade());
        }

        if (null !== $filter->getEmpenho()) {
            $qb->andWhere('fkEmpenhoEmpenho.codEmpenho = :fkEmpenhoEmpenho_codEmpenho');
            $qb->andWhere('fkEmpenhoEmpenho.exercicio = :fkEmpenhoEmpenho_exercicio');
            $qb->andWhere('fkEmpenhoEmpenho.codEntidade = :fkEmpenhoEmpenho_codEntidade');
            $qb->setParameter('codModalidade', $filter->getEmpenho()->getCodEmpenho());
            $qb->setParameter('exercicio', $filter->getEmpenho()->getExercicio());
            $qb->setParameter('codEntidade', $filter->getEmpenho()->getCodEntidade());
        }

        $qb->addGroupBy('RegistroPrecos.codEntidade');
        $qb->addGroupBy('RegistroPrecos.numeroRegistroPrecos');
        $qb->addGroupBy('RegistroPrecos.exercicio');
        $qb->addGroupBy('RegistroPrecos.numcgmGerenciador');
        $qb->addGroupBy('RegistroPrecos.interno');

        $qb->addOrderBy('RegistroPrecos.exercicio', 'DESC');
        $qb->addOrderBy('RegistroPrecos.codEntidade', 'DESC');
        $qb->addOrderBy('RegistroPrecos.numeroRegistroPrecos', 'DESC');

        return $qb;
    }
}
