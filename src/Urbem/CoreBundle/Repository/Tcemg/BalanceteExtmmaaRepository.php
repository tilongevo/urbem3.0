<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\RecDescExtraFilter;

class BalanceteExtmmaaRepository extends AbstractRepository
{
    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:229
     */
    public function getByFilter(RecDescExtraFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param RecDescExtraFilter $filter
     * @return integer
     */
    public function getTotalByFilter(RecDescExtraFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(BalancenteExtmmaa)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param RecDescExtraFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(RecDescExtraFilter $filter)
    {
        $qb = $this->createQueryBuilder('BalancenteExtmmaa');

        if (null !== $filter->getExercicio()) {
            $qb->andWhere('BalancenteExtmmaa.exercicio = :exercicio');
            $qb->setParameter('exercicio', $filter->getExercicio());
        }

        if (null !== $filter->getCategoria()) {
            $qb->andWhere('BalancenteExtmmaa.categoria = :categoria');
            $qb->setParameter('categoria', (int) $filter->getCategoria());
        }

        if (null !== $filter->getTipoLancamento()) {
            $qb->andWhere('BalancenteExtmmaa.tipoLancamento = :tipoLancamento');
            $qb->setParameter('tipoLancamento', (int) $filter->getTipoLancamento());
        }

        if (null !== $filter->getSubTipoLancamento()) {
            $qb->andWhere('BalancenteExtmmaa.subTipoLancamento = :subTipoLancamento');
            $qb->setParameter('subTipoLancamento', (int) $filter->getSubTipoLancamento());
        }

        return $qb;
    }

    /**
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterExt.php:73
     *
     * Se retornar null, não deve inserir o BalancenteExtmmaa
     *
     * @param PlanoConta $planoConta
     * @param $inSubTipo
     * @param $inTipoLancamento
     * @param $categoria
     *
     * @return null|integer
     */
    public function getSubTipoLancamento(PlanoConta $planoConta, $inSubTipo, $inTipoLancamento, $categoria)
    {
        if (999 === $inSubTipo || 99 === $inTipoLancamento) {
            $subTipos = [
                1 => 5,
                2 => 5,
                3 => 4,
                4 => 11,
                99 => 1
            ];

            $inSubTipo = true == empty($subTipos[$inTipoLancamento]) ? $inSubTipo : $subTipos[$inTipoLancamento];

            $qb = $this->createQueryBuilder('BalancenteExtmmaa');
            $qb->select('count(BalancenteExtmmaa)');
            $qb->andWhere('BalancenteExtmmaa.exercicio = :exercicio');
            $qb->andWhere('BalancenteExtmmaa.codPlano = :codPlano');
            $qb->andWhere('BalancenteExtmmaa.tipoLancamento = :tipoLancamento');
            $qb->andWhere('BalancenteExtmmaa.categoria = :categoria');
            // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterExt.php:98
            $qb->andWhere('BalancenteExtmmaa.subTipoLancamento >= :subTipoLancamento');

            $qb->setParameters([
                'exercicio' => $planoConta->getFkContabilidadePlanoAnalitica()->getExercicio(),
                'codPlano' => $planoConta->getFkContabilidadePlanoAnalitica()->getCodPlano(),
                'tipoLancamento' => $inTipoLancamento,
                'categoria' => $categoria,
                'subTipoLancamento' => $inSubTipo,
            ]);

            // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterExt.php:100
            // se encontrar, retorna null pois não pode ser inserido 2x
            if (0 < $qb->getQuery()->getSingleScalarResult()) {
                return null;
            }

            $qb = $this->createQueryBuilder('BalancenteExtmmaa');
            $qb->select('BalancenteExtmmaa.subTipoLancamento');
            $qb->andWhere('BalancenteExtmmaa.exercicio = :exercicio');
            $qb->andWhere('BalancenteExtmmaa.tipoLancamento = :tipoLancamento');
            $qb->andWhere('BalancenteExtmmaa.categoria = :categoria');
            $qb->orderBy('BalancenteExtmmaa.subTipoLancamento', 'DESC');

            $qb->setParameters([
                'exercicio' => $planoConta->getFkContabilidadePlanoAnalitica()->getExercicio(),
                'tipoLancamento' => $inTipoLancamento,
                'categoria' => $categoria,
            ]);

            $qb->setMaxResults(1);

            $found = (int) $qb->getQuery()->getSingleScalarResult();

            // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterExt.php:109
            if (0 >= $found) {
                return $inSubTipo;
            }

            return $found + 1;
        }

        $qb = $this->createQueryBuilder('BalancenteExtmmaa');
        $qb->select('count(BalancenteExtmmaa)');
        $qb->andWhere('BalancenteExtmmaa.exercicio = :exercicio');
        $qb->andWhere('BalancenteExtmmaa.codPlano = :codPlano');
        $qb->andWhere('BalancenteExtmmaa.tipoLancamento = :tipoLancamento');
        $qb->andWhere('BalancenteExtmmaa.categoria = :categoria');
        $qb->andWhere('BalancenteExtmmaa.subTipoLancamento = :subTipoLancamento');

        $qb->setParameters([
            'exercicio' => $planoConta->getFkContabilidadePlanoAnalitica()->getExercicio(),
            'codPlano' => $planoConta->getFkContabilidadePlanoAnalitica()->getCodPlano(),
            'tipoLancamento' => $inTipoLancamento,
            'categoria' => $categoria,
            'subTipoLancamento' => $inSubTipo,
        ]);

        //gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterExt.php:125
        // se encontrar, retorna null pois não pode ser inserido 2x
        if (0 < $qb->getQuery()->getSingleScalarResult()) {
            return null;
        }

        return $inSubTipo;
    }
}
