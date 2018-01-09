<?php

namespace Urbem\CoreBundle\Repository;

use Doctrine\ORM;

class SwCgmPessoaJuridicaRepository extends ORM\EntityRepository
{
    public function getDisponiveis($cgmPosto)
    {
        $qb = $this->createQueryBuilder('sw');
        $qb->leftJoin('Urbem\CoreBundle\Entity\Frota\Posto', 'p', 'WITH', 'sw.numcgm = p.cgmPosto');
        $qb->where('p.cgmPosto IS NULL');

        if ($cgmPosto) {
            $qb->orWhere('p.cgmPosto = :cgmPosto');
            $qb->setParameter('cgmPosto', $cgmPosto);
        }

        return $qb;
    }
}
