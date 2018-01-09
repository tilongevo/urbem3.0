<?php

namespace Urbem\CoreBundle\Repository\Tcers;

use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tcers\Credor;
use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class CredorRepository
 * @package Urbem\CoreBundle\Repository\Tcers
 */
class CredorRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param null $ano
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findRecuperaDadosCredorConversaoQueryBuilder($exercicio, $ano = null)
    {
        $complementJoinCredor = '';
        if (!empty($ano)) {
            $complementJoinCredor = " AND cr.exercicio = '{$ano}'";
        }

        $qb = $this->createQueryBuilder('pe');
        $qb->resetDQLPart("from");
        $qb->select("pe.exercicio, cgm.numcgm, cgm.nomCgm, cr.tipo");
        $qb->from(PreEmpenho::class, 'pe');
        $qb->join(Empenho::class, 'em', 'WITH', "em.codPreEmpenho = pe.codPreEmpenho AND pe.exercicio = em.exercicio");
        $qb->join(SwCgm::class, 'cgm', 'WITH', "pe.cgmBeneficiario = cgm.numcgm");
        $qb->leftJoin(Credor::class, 'cr', 'WITH', "cr.numcgm = cgm.numcgm AND cr.exercicio < :exercicio {$complementJoinCredor}");
        $qb->where("pe.exercicio < :exercicio");

        if (!empty($ano)) {
            $qb->andWhere("pe.exercicio = '{$ano}'");
        }

        $qb->setParameter('exercicio', $exercicio);
        $qb->groupBy("pe.exercicio, cgm.numcgm, cgm.nomCgm, cr.tipo");
        $qb->orderBy("pe.exercicio", "DESC");
        $qb->addOrderBy("cgm.numcgm", "ASC");
        $qb->addOrderBy("cgm.nomCgm", "ASC");

        return $qb;
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $usuario
     * @param $exercicio
     * @return mixed
     */
    public function findRecuperaDadosCredor(Usuario $usuario, $exercicio)
    {
        $qb = $this->findRecuperaDadosCredorQueryBuilder($usuario, $exercicio);

        return $qb->getQuery()->execute();
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $usuario
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findRecuperaDadosCredorQueryBuilder(Usuario $usuario, $exercicio)
    {
        $usuarioEntidades = $this->findOrcamentoUsuarioEntidadeQueryBuilder($exercicio, $usuario->getId());
        $usuarioEntidades = $usuarioEntidades->getQuery()->execute();
        $entidades = [];

        foreach ($usuarioEntidades as $entidade) {
            $entidades[$entidade["codEntidade"]] = $entidade["codEntidade"];
        }

        $qb = $this->createQueryBuilder('pe');
        $qb->resetDQLPart("from");
        $qb->select("pe.exercicio, cgm.numcgm, cgm.nomCgm, cr.tipo");
        $qb->from(PreEmpenho::class, 'pe');
        $qb->join(Empenho::class, 'em', 'WITH', "em.codPreEmpenho = pe.codPreEmpenho AND pe.exercicio = em.exercicio");
        $qb->join(SwCgm::class, 'cgm', 'WITH', "pe.cgmBeneficiario = cgm.numcgm");
        $qb->leftJoin(Credor::class, 'cr', 'WITH', "cr.numcgm = cgm.numcgm AND cr.exercicio = :exercicio");
        $qb->where("pe.exercicio = :exercicio");

        if (!empty($entidades)) {
            $qb->andWhere(
                $qb->expr()->in("em.codEntidade", $entidades)
            );
        }

        $qb->setParameter('exercicio', $exercicio);
        $qb->groupBy("pe.exercicio, cgm.numcgm, cgm.nomCgm, cr.tipo");
        $qb->orderBy("pe.exercicio", "DESC");
        $qb->addOrderBy("cgm.numcgm", "ASC");
        $qb->addOrderBy("cgm.nomCgm", "ASC");

        return $qb;
    }

    /**
     * @param $exercicio
     * @param $numcgm
     * @return array|\Doctrine\ORM\QueryBuilder
     */
    public function findOrcamentoUsuarioEntidadeQueryBuilder($exercicio, $numcgm)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->resetDQLPart("from");
        $qb->select("e.codEntidade");
        $qb->from(UsuarioEntidade::class, 'e');
        $qb->where("e.exercicio = :exercicio");
        $qb->andWhere("e.numcgm = :numcgm");
        $qb->setParameter('exercicio', $exercicio);
        $qb->setParameter('numcgm', $numcgm);

        return $qb;
    }

    /**
     * @param $exercicio
     * @param null $ano
     * @return mixed
     */
    public function findRecuperaDadosCredorConversao($exercicio, $ano = null)
    {
        $qb = $this->findRecuperaDadosCredorConversaoQueryBuilder($exercicio, $ano);
        return $qb->getQuery()->execute();
    }
}
