<?php

namespace Urbem\CoreBundle\Repository\Patrimonio;

use Doctrine\ORM;

class MarcaRepository extends ORM\EntityRepository
{
    public function getMarcasDisponiveis($id)
    {
        $qb = $this->createQueryBuilder('ma');
        $qb->leftJoin('Urbem\CoreBundle\Entity\Frota\Modelo', 'mo', 'WITH', 'ma.codMarca = mo.codMarca');
        $qb->where('mo.codMarca IS NULL');

        if ($id) {
            $qb->orWhere('mo.ma.codMarca = :codMarca');
            $qb->setParameter('codMarca', $id);
        }

        return $qb;
    }
}
