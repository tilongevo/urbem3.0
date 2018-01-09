<?php

namespace Urbem\CoreBundle\Repository\Tcepr;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter\SecretariaOrgaoFilter;

class SecretariaOrgaoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(SecretariaOrgaoFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(SecretariaOrgao)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param SecretariaOrgaoFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(SecretariaOrgaoFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param SecretariaOrgaoFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(SecretariaOrgaoFilter $filter)
    {
        $qb = $this->createQueryBuilder('SecretariaOrgao');

        if (null !== $filter->getIdSecretariaTce()) {
            $qb->andWhere('SecretariaOrgao.idSecretariaTce = :idSecretariaTce');
            $qb->setParameter('idSecretariaTce', $filter->getIdSecretariaTce());
        }

        return $qb;
    }
}
