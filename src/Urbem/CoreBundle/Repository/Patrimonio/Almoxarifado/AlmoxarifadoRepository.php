<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 25/07/16
 * Time: 11:42
 */

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;

class AlmoxarifadoRepository extends ORM\EntityRepository
{
    public function getAllAlmoxarifado()
    {
        $sql = "
            SELECT 
                a.cod_almoxarifado,
                c.numcgm,
                c.nom_cgm
            FROM almoxarifado.almoxarifado a
            INNER JOIN public.sw_cgm c
              ON c.numcgm = a.cgm_almoxarifado
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }
}
