<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class MapaSolicitacaoRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio\Compras
 */
class MapaSolicitacaoRepository extends AbstractRepository
{

    /**
     * @param $exercicio
     * @param $codSolicitacao
     * @param $codEntidade
     * @return mixed
     */
    public function montaRecuperaSolicitacoesMapaCompras($exercicio, $codSolicitacao, $codEntidade)
    {
        $sql = "select solicitacao.exercicio                                                                                             
     , solicitacao.cod_entidade                                                                                          
     , sw_cgm.nom_cgm as nom_entidade                                                                                    
     , solicitacao.cod_solicitacao                                                                                       
     , to_char(solicitacao.timestamp,'dd/mm/yyyy') as data                                                               
     , solicitacao.timestamp as timestamp_solicitacao                                                                    
     --- total da solicitacao                                                                                            
     , ( select sum(vl_total) as vl_total                                                                                
           from compras.solicitacao_item                                                                                 
          where solicitacao_item.exercicio       = solicitacao.exercicio                                                 
            and solicitacao_item.cod_entidade    = solicitacao.cod_entidade                                              
            and solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao )                                         
        - coalesce (                                                                                                     
                     (select sum(vl_total)                                                                               
                         from compras.solicitacao_item_anulacao                                                          
                        where solicitacao_item_anulacao.exercicio       = solicitacao.exercicio                          
                          and solicitacao_item_anulacao.cod_entidade    = solicitacao.cod_entidade                       
                          and solicitacao_item_anulacao.cod_solicitacao = solicitacao.cod_solicitacao ), 0 ) as valor_total 
  --- total em mapa                                                                                                      
, ( select COALESCE(SUM(mapa_item.vl_total),0.00)                                                                        
    from compras.mapa_item                                                                                               
   where mapa_item.exercicio       = solicitacao.exercicio                                                               
     and mapa_item.cod_entidade    = solicitacao.cod_entidade                                                            
     and mapa_item.cod_solicitacao = solicitacao.cod_solicitacao )                                                       
   -                                                                                                                     
   ( select COALESCE(SUM(mapa_item_anulacao.vl_total),0.00)                                                              
    from compras.mapa_item_anulacao                                                                                      
    where mapa_item_anulacao.exercicio       = solicitacao.exercicio                                                     
      and mapa_item_anulacao.cod_entidade    = solicitacao.cod_entidade                                                  
      and mapa_item_anulacao.cod_solicitacao = solicitacao.cod_solicitacao ) as total_mapas                              
, ( select COALESCE(SUM(mapa_item_anulacao.vl_total),0.00)                                                               
      from compras.mapa_item_anulacao                                                                                    
 where mapa_item_anulacao.exercicio_solicitacao = solicitacao.exercicio                                                  
   and mapa_item_anulacao.cod_solicitacao       = solicitacao.cod_solicitacao                                            
   and mapa_item_anulacao.cod_entidade          = solicitacao.cod_entidade ) as total_anulado                            
  from compras.solicitacao                                                                                               
  join orcamento.entidade                                                                                                
    on ( solicitacao.cod_entidade = entidade.cod_entidade                                                                
   and   solicitacao.exercicio    = entidade.exercicio   )                                                               
  join sw_cgm                                                                                                            
    on ( entidade.numcgm = sw_cgm.numcgm )                                                                               
  join compras.solicitacao_homologada                                                                                    
    on ( solicitacao_homologada.exercicio       = solicitacao.exercicio                                                  
   and  solicitacao_homologada.cod_entidade     = solicitacao.cod_entidade                                               
   and  solicitacao_homologada.cod_solicitacao  = solicitacao.cod_solicitacao )                                          
  where solicitacao.cod_solicitacao is not null                                                                          ";

        $sql .= " AND solicitacao.exercicio = '".$exercicio . "'";
        $sql .= " AND solicitacao.cod_solicitacao = ".$codSolicitacao;
        $sql .= " AND solicitacao.cod_entidade = ".$codEntidade;
        $sql .= " ORDER BY solicitacao.cod_solicitacao ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $resultado = $query->fetchAll();
        $result = array_shift($resultado);

        return $result;
    }
}
