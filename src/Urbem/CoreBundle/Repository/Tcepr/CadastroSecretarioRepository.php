<?php

namespace Urbem\CoreBundle\Repository\Tcepr;

use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter\CadastroSecretarioFilter;

class CadastroSecretarioRepository extends AbstractRepository
{
    public function getNextNumCadastro()
    {
        return $this->nextVal('num_cadastro');
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalByFilter(CadastroSecretarioFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(CadastroSecretario)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param CadastroSecretarioFilter $filter
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getByFilter(CadastroSecretarioFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param CadastroSecretarioFilter $filter
     * @return QueryBuilder
     */
    public function getByFilterAsQueryBuilder(CadastroSecretarioFilter $filter)
    {
        $qb = $this->createQueryBuilder('CadastroSecretario');

        if (null !== $filter->getNumCadastro()) {
            $qb->andWhere('CadastroSecretario.numCadastro = :numCadastro');
            $qb->setParameter('numCadastro', $filter->getNumCadastro());
        }

        return $qb;
    }
}
