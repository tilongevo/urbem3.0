<?php

namespace Urbem\CoreBundle\Repository\Beneficio;

use Doctrine\ORM;

class VigenciaRepository extends ORM\EntityRepository
{
    public function getVigenciaRepetida($dataVigencia, $tipoVigencia)
    {
        $qb = $this->createQueryBuilder('v');
        $qb->where('v.vigencia = :vigencia AND v.tipo = :tipo');
        $qb->setParameter('vigencia', $dataVigencia);
        $qb->setParameter('tipo', $tipoVigencia);

        return $qb->getQuery()->execute();
    }
}
