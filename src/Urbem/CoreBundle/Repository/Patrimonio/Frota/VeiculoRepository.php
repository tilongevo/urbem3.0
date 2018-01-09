<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Frota;

use Doctrine\ORM;

class VeiculoRepository extends ORM\EntityRepository
{
    public function getVeiculosUtilizando($veiculo)
    {
        $qb = $this->getEntityManager()->getRepository('Urbem\CoreBundle\Entity\Frota\Utilizacao')
            ->createQueryBuilder('u')
            ->leftJoin('Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno', 'ur', 'WITH', 'u.codUtilizacao = ur.codUtilizacao')
            ->where('ur.codUtilizacaoRetorno IS NULL');

        return $qb;
    }

    public function getVeiculosLivres($veiculo)
    {
        $subqb = $this->getEntityManager()->getRepository('Urbem\CoreBundle\Entity\Frota\Utilizacao')
            ->createQueryBuilder('u')
            ->select('identity(u.codVeiculo)')
            ->leftJoin('Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno', 'ur', 'WITH', 'u.codUtilizacao = ur.codUtilizacao')
            ->where('ur.codUtilizacaoRetorno IS NULL');

        $qb = $this->createQueryBuilder('v');
        $qb->where($qb->expr()->notIn('v.codVeiculo', $subqb->getDQL()));

        if ($veiculo) {
            $qb->orWhere('v.codVeiculo = :codVeiculo');
            $qb->setParameter('codVeiculo', $veiculo);
        }

        return $qb;
    }
}
