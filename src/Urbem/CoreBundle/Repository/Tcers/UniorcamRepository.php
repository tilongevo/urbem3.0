<?php

namespace Urbem\CoreBundle\Repository\Tcers;

use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\Tcers\Uniorcam;
use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class UniorcamRepository
 * @package Urbem\CoreBundle\Repository\Tcers
 */
class UniorcamRepository extends AbstractRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findExerciciosListQueryBuilder()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select('e.exercicio');
        $qb->groupBy('e.exercicio');
        $qb->orderBy('e.exercicio', 'DESC');

        return $qb;
    }

    /**
     * @return mixed
     */
    public function findExerciciosList()
    {
        $qb = $this->findExerciciosListQueryBuilder();
        return $qb->getQuery()->execute();
    }

    /**
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllUniorcamQueryBuilder($exercicio)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->resetDQLPart("from");
        $qb->select("oo.exercicio, oo.nomOrgao, oo.numOrgao, ou.nomUnidade, ou.numUnidade, tu.identificador, tu.numcgm, cgm.nomCgm");
        $qb->from(Orgao::class, 'oo');
        $qb->join(Unidade::class, 'ou', 'WITH', "oo.numOrgao = ou.numOrgao and oo.exercicio = ou.exercicio");
        $qb->leftJoin(Uniorcam::class, 'tu', 'WITH', "ou.exercicio = tu.exercicio and ou.numUnidade = tu.numUnidade and ou.numOrgao = tu.numOrgao");
        $qb->join(SwCgmPessoaJuridica::class, 'pj', 'WITH', "tu.numcgm = pj.numcgm");
        $qb->join(SwCgm::class, 'cgm', 'WITH', "pj.numcgm = cgm.numcgm");
        $qb->where("tu.numcgm > 0");
        if (!empty($exercicio)) {
            $qb->andWhere("oo.exercicio = :exercicio");
            $qb->setParameter('exercicio', $exercicio);
        }
        $qb->orderBy('oo.exercicio', 'DESC');
        $qb->addOrderBy('oo.numOrgao', 'ASC');
        $qb->addOrderBy('ou.numUnidade', 'ASC');

        return $qb;
    }

    /**
     * @return mixed
     */
    public function findUniorcamAll($exercicio)
    {
        $qb = $this->findAllUniorcamQueryBuilder($exercicio);
        return $qb->getQuery()->execute();
    }
}
