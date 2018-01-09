<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Ima;

use Doctrine\ORM;

class ConsignacaoBanrisulLiquidoRepository extends ORM\EntityRepository
{

    public function removeConsignacaoBanrisulLiquido()
    {
        $conn = $this->_em->getConnection();

        $sql = "
        DELETE
        FROM
            ima.consignacao_banrisul_liquido;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}
