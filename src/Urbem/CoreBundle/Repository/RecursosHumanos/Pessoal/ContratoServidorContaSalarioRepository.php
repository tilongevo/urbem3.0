<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class ContratoServidorContaSalarioRepository extends ORM\EntityRepository
{
    public function consulta($codContrato)
    {
        $sql = "
        SELECT
            *
        FROM pessoal.contrato_servidor_conta_salario
        WHERE cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0) {
            $this->deleteContratoServidorContaSalario($codContrato);
        }

        return $result;
    }

    public function deleteContratoServidorContaSalario($codContrato)
    {
        $sql = "
        DELETE
        FROM pessoal.contrato_servidor_conta_salario
        WHERE cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $codContrato
     * @return mixed
     */
    public function consultaSalarioMaxTimestamp($codContrato)
    {
        $sql = "select
                    salario.*
                from
                    pessoal.contrato_servidor_salario as salario,
                    (
                        select
                            cod_contrato,
                            max( timestamp ) as timestamp
                        from
                            pessoal.contrato_servidor_salario
                        group by
                            cod_contrato
                    ) max_salario
                where
                    salario.cod_contrato = max_salario.cod_contrato
                    and salario.timestamp = max_salario.timestamp
                    and salario.cod_contrato = ".$codContrato;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
}
