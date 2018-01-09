<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ConfiguracaoArquivoDclrfRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class ConfiguracaoArquivoDclrfRepository extends AbstractRepository
{
    /**
     * @param array $filters
     * @return QueryBuilder
     */
    public function findConfiguracaoArquivoDclrf(array $filters = [])
    {
        $qb = $this->createQueryBuilder('c');

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
            $qb->andWhere('c.' . $column . ' = :' . $column)->setParameter($column, $value);
        }

        return $qb;
    }
}
