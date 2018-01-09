<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;

/**
 * @ORM\Entity(repositoryClass="Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial")
 */
class EstoqueMaterialRepository extends ORM\EntityRepository
{
    /**
     * @param $codItem
     * @param $codMarca
     * @param $codAlmoxarifado
     * @param $codCentro
     * @return EstoqueMaterial
     */
    public function getEstoqueItem($codItem, $codMarca, $codAlmoxarifado, $codCentro)
    {
        $result = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->from('CoreBundle:Almoxarifado\EstoqueMaterial', 'e')
            ->select('Count(e.codItem)')
            ->where('e.codItem = ?1')
            ->andWhere('e.codMarca = ?2')
            ->andWhere('e.codCentro = ?3')
            ->andWhere('e.codCentro = ?4')
            ->setParameter(1, $codItem)
            ->setParameter(2, $codMarca)
            ->setParameter(3, $codAlmoxarifado)
            ->setParameter(4, $codCentro)
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }
}
