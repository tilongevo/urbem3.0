<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class EnquadramentoRepository extends ORM\EntityRepository
{
    public function findEnquadramentoClassificacao()
    {
        $db = $this->createQueryBuilder('cs')
            ->innerJoin('Urbem\CoreBundle\Entity\Pessoal\Servidor', 's', 'WITH', 'cs.codServidor = s.codServidor')
            ->innerJoin('Urbem\CoreBundle\Entity\SwCgm', 'c', 'WITH', 's.numcgm = c.numcgm')
            ->where("cs.ativo = true")
            ->orderBy('c.nomCgm', 'ASC');
        ;

        return $db;
    }
}
