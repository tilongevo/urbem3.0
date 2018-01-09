<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Estagio;

use Doctrine\ORM;

class CursoInstituicaoEnsinoRepository extends ORM\EntityRepository
{
    public function getInstituicaoEnsino()
    {
        $qb_cie = $this->createQueryBuilder('cgm')
            ->select('IDENTITY(cgm.numcgm) AS numcgm')
            ->groupBy('numcgm');

        return $qb_cie;
    }
}
