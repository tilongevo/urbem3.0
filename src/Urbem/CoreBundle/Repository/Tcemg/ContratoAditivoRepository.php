<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ContratoAditivoFilter;

class ContratoAditivoRepository extends AbstractRepository
{
    public function getNextCodContratoAditivo()
    {
        return $this->nextVal('cod_contrato_aditivo');
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(ContratoAditivoFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(ContratoAditivo)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param ContratoAditivoFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(ContratoAditivoFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ContratoAditivoFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(ContratoAditivoFilter $filter)
    {
        $qb = $this->createQueryBuilder('ContratoAditivo');
        $qb->join('ContratoAditivo.fkTcemgContrato', 'fkTcemgContrato');

        if (null !== $filter->getNroContrato()) {
            $qb->andWhere('fkTcemgContrato.nroContrato = :nroContrato');
            $qb->setParameter('nroContrato', $filter->getNroContrato());
        }

        if (null !== $filter->getDataAssinatura()) {
            $qb->andWhere('fkTcemgContrato.dataAssinatura = :dataAssinatura');
            $qb->setParameter('dataAssinatura', $filter->getDataAssinatura());
        }

        if (null !== $filter->getNroAditivo()) {
            $qb->andWhere('ContratoAditivo.nroAditivo = :nroAditivo');
            $qb->setParameter('nroAditivo', $filter->getNroAditivo());
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

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterAditivoContrato.php:83 */
        $qb->andWhere('fkTcemgContrato.codObjeto >= 1');

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterAditivoContrato.php:84 */
        $qb->andWhere('fkTcemgContrato.codObjeto <= 3');

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterAditivoContrato.php:85 */
        $qb->leftJoin('fkTcemgContrato.fkTcemgContratoRescisao', 'fkTcemgContratoRescisao');
        $qb->andWhere('fkTcemgContratoRescisao.codContrato IS NULL');

        $qb->addOrderBy('fkTcemgContrato.codEntidade', 'DESC');
        $qb->addOrderBy('fkTcemgContrato.exercicio', 'DESC');
        $qb->addOrderBy('fkTcemgContrato.nroContrato', 'DESC');
        $qb->addOrderBy('ContratoAditivo.nroAditivo', 'DESC');

        return $qb;
    }
}
