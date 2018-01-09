<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ContratoApostilaFilter;

class ContratoApostilaRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodApostila()
    {
        return $this->nextVal('cod_apostila');
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(ContratoApostilaFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(ContratoApostila)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param ContratoApostilaFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(ContratoApostilaFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ContratoApostilaFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(ContratoApostilaFilter $filter)
    {
        $qb = $this->createQueryBuilder('ContratoApostila');
        $qb->join('ContratoApostila.fkTcemgContrato', 'fkTcemgContrato');

        if (null !== $filter->getNroContrato()) {
            $qb->andWhere('fkTcemgContrato.nroContrato = :nroContrato');
            $qb->setParameter('nroContrato', $filter->getNroContrato());
        }

        if (null !== $filter->getDataAssinatura()) {
            $qb->andWhere('fkTcemgContrato.dataAssinatura = :dataAssinatura');
            $qb->setParameter('dataAssinatura', $filter->getDataAssinatura());
        }

        if (null !== $filter->getCodApostila()) {
            $qb->andWhere('ContratoApostila.codApostila = :codApostila');
            $qb->setParameter('codApostila', $filter->getCodApostila());
        }

        if (0 < $filter->getEntidades()->count()) {
            $orx = $qb->expr()->orX();

            $count = 1;

            /** @var Entidade $entidade */
            foreach ($filter->getEntidades() as $entidade) {
                $fkOrcamentoEntidadeCodEntidade = sprintf('fkOrcamentoEntidade_codEntidade_%s', $count);
                $count++;
                $fkOrcamentoEntidadeExercicio = sprintf('fkOrcamentoEntidade_exercicio_%s', $count);

                $andX = $qb->expr()->andX();
                $andX->add(sprintf('fkTcemgContrato.codEntidade = :%s', $fkOrcamentoEntidadeCodEntidade));
                $andX->add(sprintf('fkTcemgContrato.exercicio = :%s', $fkOrcamentoEntidadeExercicio));
                $qb->setParameter($fkOrcamentoEntidadeCodEntidade, $entidade->getCodEntidade());
                $qb->setParameter($fkOrcamentoEntidadeExercicio, $entidade->getExercicio());

                $count++;

                $orx->add($andX);
            }

            $qb->andWhere($orx);
        }

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterApostilaContrato.php:80 */
        $qb->leftJoin('fkTcemgContrato.fkTcemgContratoRescisao', 'fkTcemgContratoRescisao');
        $qb->andWhere('fkTcemgContratoRescisao.codContrato IS NULL');

        $qb->addOrderBy('fkTcemgContrato.codEntidade', 'DESC');
        $qb->addOrderBy('fkTcemgContrato.exercicio', 'DESC');
        $qb->addOrderBy('fkTcemgContrato.nroContrato', 'DESC');
        $qb->addOrderBy('ContratoApostila.codApostila', 'DESC');

        return $qb;
    }
}
