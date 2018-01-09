<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Frota;

use Doctrine\ORM;

class VeiculoDocumentoRepository extends ORM\EntityRepository
{
    public function getDocumentosLivres($params)
    {
        $subqb = $this->getEntityManager()->getRepository('CoreBundle:Frota\VeiculoDocumento')
            ->createQueryBuilder('du')
            ->select('du.codDocumento')
            ->where('du.codVeiculo = '.$params['codVeiculo'])
            ->andWhere("du.exercicio = '".$params['exercicio']."'");

        if (!empty($params['codDocumento'])) {
            $subqb
                ->andWhere("du.codDocumento <> '".$params['codDocumento']."'");
        }

        $qb = $this->getEntityManager()->getRepository('CoreBundle:Frota\Documento')
            ->createQueryBuilder('d');
        $qb->where($qb->expr()->notIn('d.codDocumento', $subqb->getDQL()));

        return $qb;
    }
}
