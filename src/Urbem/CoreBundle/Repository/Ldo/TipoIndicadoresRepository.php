<?php

namespace Urbem\CoreBundle\Repository\Ldo;

use Doctrine\ORM;

class TipoIndicadoresRepository extends ORM\EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function withQueryBuilder()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select('e');
        $qb->orderBy('e.descricao', 'ASC');

        return $qb;
    }
}
