<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class ContratoServidorSindicatoRepository extends ORM\EntityRepository
{
    public function consulta($codContrato)
    {
        $sql = "
        SELECT
            *
        FROM pessoal.contrato_servidor_sindicato
        WHERE cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0){
            $this->deleteContratoServidorSindicato($codContrato);
        }

        return $result;
    }

    public function deleteContratoServidorSindicato($codContrato)
    {
        $sql = "
        DELETE
        FROM pessoal.contrato_servidor_sindicato
        WHERE cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
