<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;

/**
 * Class OrgaoRepository
 * @package Urbem\CoreBundle\Repository\Orcamento
 */
class OrgaoRepository extends ORM\EntityRepository
{
    /**
     * @param $term
     * @return ORM\QueryBuilder
     */
    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('Orgao');

        $orx = $qb->expr()->orX();

        $like = $qb->expr()->like('string(Orgao.numOrgao)', ':term');
        $orx->add($like);

        $like = $qb->expr()->like('Orgao.nomOrgao', ':term');
        $orx->add($like);

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', $term));

        $qb->orderBy('Orgao.numOrgao');
        $qb->setMaxResults(10);

        return $qb;
    }

    /**
     * @param $exercicio
     * @return ORM\QueryBuilder
     */
    public function getByExercicioAsQueryBuilder($exercicio)
    {
        $qb = $this->createQueryBuilder('Orgao');

        $qb->andWhere('Orgao.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        $qb->orderBy('Orgao.numOrgao');

        return $qb;
    }
}
