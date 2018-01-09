<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class MovSefipRetornoRepository extends ORM\EntityRepository
{
    public function insere($codigo)
    {
        $sql = "INSERT INTO pessoal.mov_sefip_retorno(cod_sefip_retorno) VALUES($codigo)";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
    }

    public function consulta($codigo, $delete = false)
    {
        $sql = sprintf("select * from pessoal.mov_sefip_retorno where cod_sefip_retorno = %d", $codigo);
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0 && $delete){
            $this->deleteMovSefipRetorno($codigo);
        }

        return $result;
    }

    public function deleteMovSefipRetorno($codigo)
    {
        $sql = sprintf("DELETE FROM pessoal.mov_sefip_retorno WHERE cod_sefip_retorno = %d", $codigo);
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
