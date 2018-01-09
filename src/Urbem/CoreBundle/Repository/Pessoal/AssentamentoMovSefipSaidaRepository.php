<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class AssentamentoGeradoRepository
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class AssentamentoMovSefipSaidaRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function recuperaRelacionamento($filtro)
    {
        $sql = <<<SQL
  SELECT                                                 
        PAS.cod_sefip_saida,                               
        SE.num_sefip                                       
    FROM                                                   
      (select                                              
            cod_assentamento, max(timestamp) as timestamp  
        from                                               
            pessoal.assentamento                       
        group by cod_assentamento) as pa,                  
       pessoal.assentamento_mov_sefip_saida as PAS,    
       pessoal.mov_sefip_saida as MSS,                 
       pessoal.sefip as SE                             
    WHERE                                                  
        PA.cod_assentamento = PAS.cod_assentamento and     
        PA.timestamp = PAS.timestamp  and                  
        PAS.cod_sefip_saida = MSS.cod_sefip_saida and      
        MSS.cod_sefip_saida = SE.cod_sefip   
SQL;
        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = array_shift($query->fetchAll(\PDO::FETCH_OBJ));
        $result = $queryResult;
        return $result;
    }

    /**
     * @param $filtro
     *
     * @return array
     */
    public function recuperaAfastamentoTemporarioSefip($filtro)
    {
        $sql = "SELECT assentamento_gerado.*                                                                                                
         , sefip.*                                                                                                              
      FROM pessoal.assentamento_gerado                                                                                          
         , (SELECT cod_assentamento_gerado                                                                                      
                 , max(timestamp) as timestamp                                                                                  
              FROM pessoal.assentamento_gerado                                                                                  
           GROUP BY cod_assentamento_gerado) as max_assentamento_gerado                                                         
         , pessoal.assentamento_gerado_contrato_servidor                                                                        
         , pessoal.assentamento_assentamento                                                                                    
         , pessoal.assentamento                                                                                                 
         , (SELECT cod_assentamento                                                                                             
                 , max(timestamp) as timestamp                                                                                  
              FROM pessoal.assentamento                                                                                         
           GROUP BY cod_assentamento) as max_assentamento                                                                       
         , pessoal.classificacao_assentamento                                                                                   
         , pessoal.assentamento_mov_sefip_saida                                                                                 
         , pessoal.sefip                                                                                                        
     WHERE assentamento_gerado.cod_assentamento_gerado = max_assentamento_gerado.cod_assentamento_gerado                        
       AND assentamento_gerado.timestamp = max_assentamento_gerado.timestamp                                                    
       AND assentamento_gerado.cod_assentamento_gerado = assentamento_gerado_contrato_servidor.cod_assentamento_gerado          
       AND assentamento_gerado.cod_assentamento = assentamento_assentamento.cod_assentamento                                    
       AND assentamento_assentamento.cod_classificacao = classificacao_assentamento.cod_classificacao                           
       AND assentamento_assentamento.cod_assentamento = assentamento.cod_assentamento                                           
       AND assentamento.cod_assentamento = max_assentamento.cod_assentamento                                                    
       AND assentamento.timestamp = max_assentamento.timestamp                                                                  
       AND assentamento.cod_assentamento = assentamento_mov_sefip_saida.cod_assentamento                                        
       AND assentamento.timestamp = assentamento_mov_sefip_saida.timestamp                                                      
       AND assentamento_mov_sefip_saida.cod_sefip_saida = sefip.cod_sefip                                                       
       AND assentamento_gerado.cod_assentamento_gerado NOT IN (SELECT cod_assentamento_gerado                                   
                                                                 FROM pessoal.assentamento_gerado_excluido)";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = $query->fetchAll(\PDO::FETCH_OBJ);
        $result = $queryResult;
        return $result;
    }
}
