<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ConsideracaoArquivoRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class ConsideracaoArquivoRepository extends AbstractRepository
{
    /**
     * @param array $filters
     * @return QueryBuilder
     */
    public function findConsideracoes(array $filters = [])
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.codArquivo, c.nomArquivo, d.codEntidade, d.exercicio, d.descricao')
            ->join('Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao', 'd', 'WITH', 'c.codArquivo = d.codArquivo')
            ->orderBy('d.codArquivo');

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
            switch ($column) {
                case 'exercicio':
                    $qb->andWhere('d.exercicio = :' . $column)->setParameter($column, $value);
                    break;
                case 'codEntidade':
                    $qb->andWhere('d.codEntidade = :' . $column)->setParameter($column, $value);
                    break;
                case 'periodo':
                    $qb->andWhere('d.periodo = :' . $column)->setParameter($column, $value);
                    break;
                case 'moduloSicom':
                    $qb->andWhere('d.moduloSicom = :' . $column)->setParameter($column, $value);
                    break;
            }
        }

        return $qb;
    }
}