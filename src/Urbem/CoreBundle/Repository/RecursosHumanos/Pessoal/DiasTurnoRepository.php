<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class DiasTurnoRepository extends ORM\EntityRepository
{
    const COD_DIA_LIMITE = 8;

    public function findDiasDaSemana()
    {
        $db = $this->createQueryBuilder('ds')
            ->where('ds.codDia < :codDia')
            ->orderBy('ds.codDia', 'ASC')
            ->setParameter('codDia', self::COD_DIA_LIMITE)
        ;

        return $db;
    }
}
