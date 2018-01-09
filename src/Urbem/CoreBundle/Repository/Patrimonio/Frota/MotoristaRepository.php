<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Frota;

use Doctrine\ORM;

class MotoristaRepository extends ORM\EntityRepository
{
    public function getMotoristaVeiculo($id)
    {
        $sql = "
            SELECT mv.cod_veiculo
            FROM   frota.motorista m
                inner join frota.motorista_veiculo mv
                    ON mv.cgm_motorista = m.cgm_motorista
            WHERE m.cgm_motorista = $id;
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function updateCgmMotorista($cgm, $numcnh, $validadecnh, $categoriacnh)
    {
        $sql = "
            UPDATE sw_cgm_pessoa_fisica 
            SET 
                num_cnh = '$numcnh',
                dt_validade_cnh = '".$validadecnh."',
                cod_categoria_cnh = $categoriacnh
            WHERE numcgm = $cgm 
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        return $query->execute();
    }
}
