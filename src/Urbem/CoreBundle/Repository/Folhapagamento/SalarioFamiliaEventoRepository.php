<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class SalarioFamiliaEventoRepository extends AbstractRepository
{
    /**
     * @param bool $filtro
     *
     * @return array
     */
    public function recuperaRelacionamento($filtro = false)
    {
        $sql = <<<SQL
SELECT fsfe.cod_regime_previdencia                                     					
              , TO_CHAR(fsfe.timestamp,'yyyy-mm-dd hh24:mi:ss.us') AS timestamp 					
              , fsfe.cod_tipo                                                   					
              , fsfe.cod_evento                                                 					
              , fe.codigo                                                       					
              , fe.descricao as descricao_evento                                					
           FROM folhapagamento.salario_familia_evento fsfe                      					
           JOIN ( SELECT cod_tipo											   					
        		          , cod_regime_previdencia								   					
        			      , max(timestamp) as timestamp							   					
            	       FROM folhapagamento.salario_familia_evento				   					
        	       GROUP BY cod_tipo											   					
        		          , cod_regime_previdencia) as max_salario_familia_evento  					
        	    ON max_salario_familia_evento.cod_tipo = fsfe.cod_tipo			   					
        	   AND max_salario_familia_evento.cod_regime_previdencia = fsfe.cod_regime_previdencia 	
        	   AND max_salario_familia_evento.timestamp = fsfe.timestamp		   					
           JOIN folhapagamento.evento fe                                        					
             ON fe.cod_evento = fsfe.cod_evento  
SQL;

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        $result = array_shift($result);

        return $result;
    }
}
