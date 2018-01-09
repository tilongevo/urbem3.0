<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;

class UnidadeRepository extends ORM\EntityRepository
{
    /**
     * @deprecated Use Method findUnidadeByExercicioAndOrgao:63
     * @param $exercicio
     * @param $numOrgao
     * @return array
     */
    public function getUnidadeNumOrgao($exercicio, $numOrgao)
    {
        $sql = "
        SELECT
            unidade.*,
            unidade.nom_unidade,
            orgao.nom_orgao,
            sw_cgm.nom_cgm AS nome_usuario
        FROM
            orcamento.unidade
            INNER JOIN orcamento.orgao ON unidade.exercicio = orgao.exercicio
                AND unidade.num_orgao = orgao.num_orgao
            INNER JOIN sw_cgm ON sw_cgm.numcgm = unidade.usuario_responsavel
            WHERE
                unidade.exercicio = :exercicio
                AND unidade.num_orgao = :num_orgao
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('num_orgao', $numOrgao, \PDO::PARAM_INT);
        
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('Unidade');

        $orx = $qb->expr()->orX();

        $like = $qb->expr()->like('string(Unidade.numUnidade)', ':term');
        $orx->add($like);

        $like = $qb->expr()->like('Unidade.nomUnidade', ':term');
        $orx->add($like);

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', $term));

        $qb->orderBy('Unidade.numUnidade');
        $qb->setMaxResults(10);

        return $qb;
    }

    /**
     * @param $exercicio
     * @param $orgao
     * @return ORM\QueryBuilder
     */
    public function findUnidadeByExercicioAndOrgao($exercicio, $orgao)
    {
        $qb = $this->createQueryBuilder('u')
            ->innerJoin('Urbem\CoreBundle\Entity\Orcamento\Orgao', 'o', 'WITH', 'u.exercicio = o.exercicio AND u.numOrgao = o.numOrgao')
            ->innerJoin('Urbem\CoreBundle\Entity\SwCgm', 'sw', 'WITH', 'u.usuarioResponsavel = sw.numcgm')
            ->where('u.exercicio = :exercicio')
            ->andWhere('o.numOrgao = :numOrgao')
            ->orderBy('u.numUnidade')
            ->setParameter('exercicio', $exercicio)
            ->setParameter('numOrgao', $orgao);

        return $qb;
    }

    /**
     * @param $exercicio
     * @param Orgao|null $orgao
     * @return ORM\QueryBuilder
     */
    public function getByExercicioAndOrgaoAsQueryBuilder($exercicio, Orgao $orgao = null)
    {
        $qb = $this->createQueryBuilder('Unidade');

        if (null === $orgao) {
            $qb->andWhere('1 = 0');

            return $qb;
        }

        $qb->andWhere('Unidade.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        $qb->join('Unidade.fkOrcamentoOrgao', 'fkOrcamentoOrgao');

        $qb->andWhere('fkOrcamentoOrgao.exercicio = :fkOrcamentoOrgao_exercicio');
        $qb->andWhere('fkOrcamentoOrgao.numOrgao = :fkOrcamentoOrgao_numOrgao');
        $qb->setParameter('fkOrcamentoOrgao_exercicio', $orgao->getExercicio());
        $qb->setParameter('fkOrcamentoOrgao_numOrgao', $orgao->getNumOrgao());

        $qb->orderBy('Unidade.numUnidade');

        return $qb;
    }
}