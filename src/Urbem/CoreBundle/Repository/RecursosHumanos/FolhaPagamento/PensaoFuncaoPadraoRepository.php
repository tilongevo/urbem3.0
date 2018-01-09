<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class PensaoFuncaoPadraoRepository extends ORM\EntityRepository
{
    public function consultaPensaoFuncaoPadrao($object)
    {
        $sql = "
        SELECT
            *
        FROM folhapagamento.pensao_funcao_padrao
        WHERE id = $object";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0) {
            $this->deletePensaoFuncaoPadrao($object);
        }

        return $result;
    }

    public function deletePensaoFuncaoPadrao($object)
    {
        $sql = "
        DELETE
        FROM folhapagamento.pensao_funcao_padrao
        WHERE id = $object";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function recuperaPensaoFuncaoPadrao()
    {
        $sql = "select *                                                                                                   
	    from folhapagamento.pensao_funcao_padrao                                                                   
	    inner join ( select cod_configuracao_pensao, max (timestamp) as max_timestamp 
	    from folhapagamento.pensao_funcao_padrao group by cod_configuracao_pensao ) as max_pensao_funcao_padrao                                 
	    on ( max_pensao_funcao_padrao.max_timestamp = pensao_funcao_padrao.timestamp                            
	    and max_pensao_funcao_padrao.cod_configuracao_pensao = max_pensao_funcao_padrao.cod_configuracao_pensao) ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
