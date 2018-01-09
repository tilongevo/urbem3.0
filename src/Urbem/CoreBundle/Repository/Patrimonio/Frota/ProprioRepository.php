<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Frota;

use Doctrine\ORM;

class ProprioRepository extends ORM\EntityRepository
{
    public function getVeiculosDisponiveis($codVeiculo)
    {
        $sql = "
            SELECT
                v.cod_veiculo,
                v.placa,
                m.nom_marca,
                mo.nom_modelo 
            FROM
                frota.veiculo AS v
            LEFT JOIN
                frota.modelo AS mo
                ON
                    v.cod_modelo = mo.cod_modelo
            LEFT JOIN
                frota.marca AS m
                ON
                    v.cod_marca = m.cod_marca
            WHERE
                v.cod_veiculo <> 0 
                AND NOT EXISTS ( 
                    SELECT 1 
                    FROM frota.proprio
                    WHERE proprio.cod_veiculo = v.cod_veiculo 
                    AND v.cod_veiculo <> $codVeiculo
                ) 
                AND NOT EXISTS ( 
                    SELECT 1
                    FROM frota.terceiros
                    WHERE terceiros.cod_veiculo = v.cod_veiculo
                    AND v.cod_veiculo <> $codVeiculo
                )";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }
}
