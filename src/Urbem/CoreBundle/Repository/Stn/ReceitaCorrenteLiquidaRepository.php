<?php

namespace Urbem\CoreBundle\Repository\Stn;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ReceitaCorrenteLiquidaRepository
 * @package Urbem\CoreBundle\Repository\Stn
 */
class ReceitaCorrenteLiquidaRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $codEntidade
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findValores($exercicio, $codEntidade)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.exercicio <= :exercicio')
            ->andWhere('r.codEntidade = :codEntidade')
            ->setParameter('exercicio', $exercicio)
            ->setParameter('codEntidade', $codEntidade)
            ->orderBy('r.mes', 'desc')
            ->addOrderBy('r.ano', 'desc');

        return $qb;
    }
}
