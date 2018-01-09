<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Ima;

use Doctrine\ORM;

class ConsignacaoBanrisulRemuneracaoRepository extends ORM\EntityRepository
{

    public function removeConsignacaoBanrisulRemuneracao()
    {
        $conn = $this->_em->getConnection();

        $sql = "
        DELETE
        FROM
            ima.consignacao_banrisul_remuneracao;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}
