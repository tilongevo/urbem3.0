<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class PoderPublicoRepository extends AbstractRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAsQueryBuilder()
    {
        $qb = $this->createQueryBuilder('PoderPublico');
        $qb->orderBy('PoderPublico.codPoder');

        return $qb;
    }
}
