<?php

namespace Urbem\CoreBundle\Repository;

use Doctrine\ORM;

class SwCgmPessoaFisicaRepository extends ORM\EntityRepository
{
    public function getCgmSelecionado($id)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->leftJoin('Urbem\CoreBundle\Entity\Pessoal\Servidor', 'c', 'WITH', 'c.numcgm = s.numcgm');
        $qb->where('c.codServidor = :id');
        $qb->setParameter('id', $id);

        return $qb;
    }

    /**
     * Busca para autocomplete de cgm que não é servidor por numcgm e pelo nome do cgm
     * @param  string|integer $term
     * @return ORM\QueryBuilder
     */
    public function getSwCgmPessoaFisicaQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->innerJoin('s.fkSwCgm', 'cgm');
        $qb->where('cgm.numcgm != 0');

        if (is_numeric($term)) {
            $qb->andWhere('cgm.numcgm = :numcgm');
            $qb->setParameter('numcgm', "{$term}");
        } else {
            $term = strtolower($term);
            $qb->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm');
            $qb->setParameter('nomCgm', "%{$term}%");
        }

        $qb->orderBy('cgm.nomCgm', 'ASC');

        $qb->setMaxResults(10);

        return $qb;
    }
}
