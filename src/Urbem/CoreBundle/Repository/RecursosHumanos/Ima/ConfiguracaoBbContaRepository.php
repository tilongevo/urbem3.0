<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Ima;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ConfiguracaoBbContaRepository extends AbstractRepository
{
    /**
     * @param $stFiltro
     * @param $stOrdem
     *
     * @return mixed
     */
    public function recuperaVigencias($stFiltro, $stOrdem)
    {
        $stSql = <<<SQL
SELECT ultima_vigencia_competencia.vigencia as dt_vigencia						
           , to_char(ultima_vigencia_competencia.vigencia,'dd/mm/yyyy') as vigencia	
           , ultima_vigencia_competencia.cod_periodo_movimentacao 					
        FROM (   SELECT DISTINCT max(vigencia) as vigencia							
                      , ( SELECT cod_periodo_movimentacao 							
                            FROM folhapagamento.periodo_movimentacao					
                           WHERE vigencia BETWEEN dt_inicial AND dt_final			
                        ) as cod_periodo_movimentacao 								
                   FROM ima.configuracao_bb_conta 									
               GROUP BY cod_periodo_movimentacao 									
             ) as ultima_vigencia_competencia
SQL;

        if ($stFiltro) {
            $stSql .= $stFiltro;
        }

        if ($stOrdem) {
            $stSql .= $stOrdem;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function recuperaRelacionamento($params)
    {
        $stSql ="
        SELECT configuracao_bb_conta.*                                                          
             , conta_corrente.num_conta_corrente                                                
             , agencia.num_agencia                                                              
             , agencia.nom_agencia                                                              
             , banco.num_banco                                                                  
             , banco.nom_banco                                                                  
          FROM ima.configuracao_bb_conta                                                        
    INNER JOIN monetario.conta_corrente                                                         
            ON configuracao_bb_conta.cod_conta_corrente = conta_corrente.cod_conta_corrente     
           AND configuracao_bb_conta.cod_agencia = conta_corrente.cod_agencia                   
           AND configuracao_bb_conta.cod_banco   = conta_corrente.cod_banco                     
    INNER JOIN ( SELECT configuracao_bb_conta.cod_convenio									   
    		   			 , max(configuracao_bb_conta.timestamp) as timestamp                       
    		  	      FROM ima.configuracao_bb_conta                                               
    		  		 WHERE configuracao_bb_conta.vigencia = to_date('".$params["vigencia"]."','dd/mm/yyyy') 
    			  GROUP BY configuracao_bb_conta.cod_convenio                                      
    			  ) as max_configuracao_bb_conta                                                   
    		   ON configuracao_bb_conta.cod_convenio = max_configuracao_bb_conta.cod_convenio      
    		  AND configuracao_bb_conta.timestamp = max_configuracao_bb_conta.timestamp 		   
    INNER JOIN monetario.agencia                                                                
            ON conta_corrente.cod_agencia = agencia.cod_agencia                                 
           AND conta_corrente.cod_banco   = agencia.cod_banco                                   
    INNER JOIN monetario.banco                                                                  
            ON agencia.cod_banco = banco.cod_banco;
        ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
