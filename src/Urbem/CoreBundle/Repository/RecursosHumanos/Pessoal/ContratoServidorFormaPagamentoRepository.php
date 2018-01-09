<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class ContratoServidorFormaPagamentoRepository extends ORM\EntityRepository
{
    public function consulta($codContrato)
    {
        $sql = "
        SELECT
            *
        FROM pessoal.contrato_servidor_forma_pagamento
        WHERE cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0){
            $this->deleteContratoServidorFormaPagamento($codContrato);
        }

        return $result;
    }

    public function deleteContratoServidorFormaPagamento($codContrato)
    {
        $sql = "
        DELETE
        FROM pessoal.contrato_servidor_forma_pagamento
        WHERE cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
