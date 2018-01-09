<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class MesRepository extends AbstractRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAsQueryBuilder()
    {
        $qb = $this->createQueryBuilder('Mes');
        $qb->orderBy('Mes.codMes');

        return $qb;
    }
}
