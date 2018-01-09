<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class UltimoRegistroEventoFeriasRepository extends AbstractRepository
{
    /**
     * @param null $filtro
     * @param null $ordem
     * @return object
     */
    public function recuperaRegistrosEventoFeriasDoContrato($filtro = null, $ordem = null)
    {
        $sql = "
        SELECT ultimo_registro_evento_ferias.*                                                      
            , registro_evento_ferias.cod_contrato                                                  
        FROM folhapagamento.ultimo_registro_evento_ferias                                         
             , folhapagamento.registro_evento_ferias                                                
        WHERE ultimo_registro_evento_ferias.cod_registro = registro_evento_ferias.cod_registro     
           AND ultimo_registro_evento_ferias.cod_evento = registro_evento_ferias.cod_evento         
           AND ultimo_registro_evento_ferias.timestamp = registro_evento_ferias.timestamp";

        if ($filtro) {
            $sql .= $filtro;
        }

        $ordem = $ordem ? " ORDER BY ".$ordem : " ORDER BY ultimo_registro_evento_ferias.cod_registro ";
        $sql .= $ordem;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
