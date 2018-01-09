<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM;

/**
 * @ORM\Entity(repositoryClass="Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel")
 */
class LancamentoPerecivelRepository extends ORM\EntityRepository
{

    /**
     * @param Array $pereciveis
     * @return Collection
     */
    public function getLancamentosByPereciveis(array $pereciveis)
    {
        $lp = $this->_em->createQueryBuilder()
            ->select('l')
            ->from('CoreBundle:Almoxarifado\LancamentoPerecivel', 'l')
            ->join('l.fkAlmoxarifadoPerecivel', 'p')
            ->where('p.codAlmoxarifado = :codAlmoxarifado')
            ->andWhere('p.codCentro = :codCentro')
            ->andWhere('p.codMarca = :codMarca')
            ->andWhere('p.codItem = :codItem')
            ->setParameters($pereciveis)
            ->getQuery()
            ->getResult();

        return $lp;
    }
}
