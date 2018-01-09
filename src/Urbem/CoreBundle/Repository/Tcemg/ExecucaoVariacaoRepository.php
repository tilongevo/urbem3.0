<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ExecucaoVariacaoRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class ExecucaoVariacaoRepository extends AbstractRepository
{
    /**
     * @param array $filters
     * @return QueryBuilder
     */
    public function searchBy(array $filters = [])
    {
        $qb = $this->createQueryBuilder('e');

        $this->addFilterQueryBuilder($qb, $filters);

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param array $filters
     * @return QueryBuilder
     */
    protected function addFilterQueryBuilder(QueryBuilder $qb, array $filters)
    {
        foreach ($filters as $column => $value) {
            if (is_null($value) or empty($value)) {
                continue;
            }
            $qb->andWhere('e.' . $column . ' = :' . $column)->setParameter($column, $value);
        }

        return $qb;
    }
}
