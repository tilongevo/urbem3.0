<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 28/09/16
 * Time: 11:12
 */

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM\EntityRepository;

class InventarioRepository extends EntityRepository
{
    /**
     * @return string
     */
    public function getAvailableCodInventario()
    {
        $sql = "SELECT COALESCE(MAX(cod_inventario), 0) + 1 AS cod_inventario FROM almoxarifado.inventario;";

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result['cod_inventario'];
    }
}
