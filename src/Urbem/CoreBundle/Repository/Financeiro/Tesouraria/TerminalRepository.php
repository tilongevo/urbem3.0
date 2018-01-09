<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class TerminalRepository extends ORM\EntityRepository
{

    /**
     * Busca no banco de dados os usuarios que podem ser vinculados a um terminal
     * @return array
     */
    public function findAllUsuariosTerminalCgm()
    {
        $sql = "SELECT                           
                     CGM.numcgm,                  
                     CGM.nom_cgm,                 
                     PF.cpf,                      
                     PJ.cnpj,                     
                     CASE WHEN PF.cpf IS NOT NULL THEN PF.cpf ELSE PJ.cnpj END AS documento 
                 FROM                             
                     SW_CGM AS CGM                
                 LEFT JOIN                        
                     sw_cgm_pessoa_fisica AS PF   
                 ON                               
                     CGM.numcgm = PF.numcgm       
                 LEFT JOIN                        
                     sw_cgm_pessoa_juridica AS PJ 
                 ON                               
                     CGM.numcgm = PJ.numcgm       
                 WHERE                            
                     CGM.numcgm <> 0              
                 AND CGM.numcgm IN (select numcgm from administracao.usuario where status='A')  order by lower(cgm.nom_cgm)";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Verifica se tem boletins abertos vinculados com um terminal
     * @param $codBoletim
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function verificarSeTemBoletmAberto($codBoletim, $exercicio, $codEntidade)
    {
        $sql = "SELECT TB.cod_boletim
	                  ,TB.exercicio
	                  ,TB.cod_entidade
	                  ,TB.cod_terminal
	                  ,TB.timestamp_terminal
	                  ,TB.cgm_usuario
	                  ,TB.timestamp_usuario
	                  ,TB.dt_boletim
	                  ,TBF.timestamp_fechamento
	                  ,TBR.timestamp_reabertura
	                  ,TO_CHAR( TB.dt_boletim, 'dd/mm/yyyy' ) as data_boletim
	                  ,TO_CHAR( TBF.timestamp_fechamento, 'dd/mm/yyyy - HH24:mm:ss' ) as dt_fechamento
	                  ,CGM.nom_cgm
	                  ,TBL.timestamp_liberado
	                  ,CASE WHEN TBF.timestamp_fechamento IS NOT NULL
	                    THEN CASE WHEN TBR.timestamp_reabertura IS NOT NULL
	                          THEN CASE WHEN TBF.timestamp_fechamento >= TBR.timestamp_reabertura
	                                THEN CASE WHEN TBL.timestamp_liberado IS NOT NULL
	                                      THEN 'liberado'
	                                      ELSE 'fechado'
	                                     END
	                                ELSE 'reaberto'
	                               END
	                          ELSE CASE WHEN TBL.timestamp_liberado IS NOT NULL
	                                 THEN 'liberado'
	                                 ELSE 'fechado'
	                               END
	                         END
	                    ELSE 'aberto'
	                   END AS situacao
	            FROM tesouraria.boletim AS TB
	            LEFT JOIN( SELECT TBF.cod_boletim
	                             ,TBF.exercicio
	                             ,TBF.cod_entidade
	                             ,MAX( TBF.timestamp_fechamento ) as timestamp_fechamento
	                       FROM tesouraria.boletim_fechado AS TBF
	                       GROUP BY cod_boletim
	                               ,exercicio
	                               ,cod_entidade
	                       ORDER BY cod_boletim
	                               ,exercicio
	                               ,cod_entidade
	            ) AS TBF ON( TB.cod_boletim = TBF.cod_boletim
                AND TB.exercicio   = TBF.exercicio
                AND TB.cod_entidade= TBF.cod_entidade )
                        LEFT JOIN( SELECT TBR.cod_boletim
                                         ,TBR.exercicio
                                         ,TBR.cod_entidade
                                         ,MAX( TBR.timestamp_reabertura ) as timestamp_reabertura
                                   FROM tesouraria.boletim_reaberto AS TBR
                                   GROUP BY TBR.cod_boletim
                                           ,TBR.exercicio
                                           ,TBR.cod_entidade
                                   ORDER BY TBR.cod_boletim
                                           ,TBR.exercicio
                                           ,TBR.cod_entidade
                        ) AS TBR ON( TB.cod_boletim = TBR.cod_boletim
                AND TB.exercicio   = TBR.exercicio
                AND TB.cod_entidade= TBR.cod_entidade )
                        LEFT JOIN( SELECT TBL.cod_boletim
                                         ,TBL.exercicio
                                         ,TBL.cod_entidade
                                         ,MAX( TBL.timestamp_liberado  ) as timestamp_liberado
                                   FROM tesouraria.boletim_liberado   AS TBL
                                   GROUP BY TBL.cod_boletim
                                           ,TBL.exercicio
                                           ,TBL.cod_entidade
                                   ORDER BY TBL.cod_boletim
                                           ,TBL.exercicio
                                           ,TBL.cod_entidade
                        ) AS TBL ON( TB.cod_boletim = TBL.cod_boletim
                AND TB.exercicio   = TBL.exercicio
                AND TB.cod_entidade= TBL.cod_entidade )
                        ,sw_cgm as CGM
                        WHERE TB.cgm_usuario = CGM.numcgm
            AND  TB.exercicio = :exercicio AND  TB.cod_boletim = :cod_boletim AND  TB.cod_entidade IN ( :cod_entidade )";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_boletim', $codBoletim);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Verifica se o terminal esta ativo ou inativo
     * @param $codTerminal
     * @return mixed
     */
    public function statusTerminal($codTerminal)
    {
        $sql = " SELECT                                                              
                     tbl.*,                                                          
                     CASE                                                            
                         WHEN tbl.timestamp_desativado is null THEN 'Ativo'          
                         WHEN tbl.timestamp_desativado is not null THEN 'Inativo'    
                     END as situacao                                                 
                                                                                     
                 FROM(                                                               
                     SELECT                                                          
                         TT.timestamp_terminal,                                      
                         TT.cod_terminal,                                            
                         TT.cod_verificador,                                         
                         UT.cgm_usuario,                                             
                         UT.timestamp_usuario,                                       
                         CGM.nom_cgm,                                                
                         TD.timestamp_desativado,                                    
                         UTE.timestamp_excluido                                      
                     FROM                                                            
                         tesouraria.terminal as TT                                   
                     LEFT JOIN tesouraria.terminal_desativado     as TD on(          
                         TT.cod_terminal         = TD.cod_terminal                   
                     AND TT.timestamp_terminal   = TD.timestamp_terminal             
                     ),                                                              
                     tesouraria.usuario_terminal as UT                               
                     LEFT JOIN tesouraria.usuario_terminal_excluido as UTE on(       
                         UT.timestamp_usuario    = UTE.timestamp_usuario             
                     AND UT.timestamp_terminal   = UTE.timestamp_terminal            
                     AND UT.cod_terminal         = UTE.cod_terminal                  
                     AND UT.cgm_usuario          = UTE.cgm_usuario                   
                     ),                                                              
                     sw_cgm                      as CGM                              
                     WHERE                                                           
                         UT.cgm_usuario          = CGM.numcgm                        
                     AND TT.timestamp_terminal   = UT.timestamp_terminal             
                     AND TT.cod_terminal         = UT.cod_terminal                   
                     AND UT.responsavel          = true                              
                     AND UTE.timestamp_excluido is null                              
                 ) as tbl                                                            
                 WHERE  cod_terminal = :cod_terminal ORDER BY cod_terminal,timestamp_terminal";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_terminal', $codTerminal);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Verifica se o terminal relacionado com uma abertura, esta:
     * Em aberto: Existe uma Abertura para esse terminal
     * Não Aberto: Não Existe uma Abertura para esse terminal
     * Fechado: O terminal esta com o status fechado
     * Reaberto: que Existe Abertura
     * @param $codTerminal
     * @param $exercicioBoletim
     * @param $codEntidade
     * @return mixed
     */
    public function statusTerminalPorTerminalExercicioEntidade($codTerminal, $exercicioBoletim, $codEntidade)
    {
        $sql = "SELECT TT.cod_terminal                                                               
                      ,TTD.timestamp_desativado                                                      
                      ,TT.timestamp_terminal                                                         
                      ,TT.cod_verificador                                                            
                      ,TA.exercicio_boletim                                                          
                      ,TA.cod_entidade                                                               
                      ,TA.cod_boletim                                                                
                      ,TA.timestamp_abertura                                                         
                      ,TF.timestamp_fechamento                                                       
                      ,TUT.cgm_usuario                                                               
                      ,CGM.nom_cgm                                                                   
                      ,TUT.timestamp_usuario                                                         
                      ,TO_CHAR(TA.timestamp_abertura  ,'dd/mm/yyyy') AS dt_abertura                  
                      ,TO_CHAR(TF.timestamp_fechamento,'dd/mm/yyyy') AS dt_fechamento                
                      ,CASE WHEN TA.timestamp_abertura IS NULL                                       
                        THEN 'nao aberto'                                                            
                        ELSE CASE WHEN TF.timestamp_fechamento IS NULL                               
                              THEN 'aberto'                                                          
                              ELSE CASE WHEN TA.timestamp_abertura >= TF.timestamp_fechamento        
                                    THEN 'reaberto'                                                  
                                    ELSE 'fechado'                                                   
                                   END                                                               
                             END                                                                     
                       END AS situacao                                                               
                FROM tesouraria.terminal AS TT                                                       
                LEFT JOIN( SELECT TA.exercicio_boletim                                               
                                 ,TA.cod_entidade                                                    
                                 ,TA.cod_boletim                                                     
                                 ,TA.cod_terminal                                                    
                                 ,TA.timestamp_terminal                                              
                                 ,MAX( TA.timestamp_abertura ) AS timestamp_abertura                 
                           FROM tesouraria.abertura AS TA                                            
                           GROUP BY TA.exercicio_boletim                                             
                                   ,TA.cod_entidade                                                  
                                   ,TA.cod_boletim                                                   
                                   ,TA.cod_terminal                                                  
                                   ,TA.timestamp_terminal                                            
                           ORDER BY TA.exercicio_boletim                                             
                                   ,TA.cod_entidade                                                  
                                   ,TA.cod_boletim                                                   
                                   ,TA.cod_terminal                                                  
                                   ,TA.timestamp_terminal                                            
                                   ,TA.timestamp_terminal                                            
                ) AS TA ON( TT.cod_terminal       = TA.cod_terminal                                  
                        AND TT.timestamp_terminal = TA.timestamp_terminal )                          
                LEFT JOIN( SELECT TF.cod_terminal                                                    
                                 ,TF.timestamp_terminal                                              
                                 ,TF.exercicio_boletim                                               
                                 ,TF.cod_entidade                                                    
                                 ,TF.cod_boletim                                                     
                                 ,MAX( timestamp_fechamento  ) AS timestamp_fechamento               
                           FROM tesouraria.abertura   AS TA                                          
                               ,tesouraria.fechamento AS TF                                          
                           WHERE TA.cod_terminal       = TF.cod_terminal                             
                             AND TA.timestamp_terminal = TF.timestamp_terminal                       
                             AND TA.timestamp_abertura = TF.timestamp_abertura                       
                           GROUP BY TF.cod_terminal                                                  
                                   ,TF.timestamp_terminal                                            
                                   ,TF.exercicio_boletim                                             
                                   ,TF.cod_entidade                                                  
                                   ,TF.cod_boletim                                                   
                           ORDER BY TF.cod_terminal                                                  
                                   ,TF.timestamp_terminal                                            
                                   ,TF.exercicio_boletim                                             
                                   ,TF.cod_entidade                                                  
                                   ,TF.cod_boletim                                                   
                ) AS TF ON( TA.cod_terminal = TF.cod_terminal                                        
                        AND TA.timestamp_terminal = TF.timestamp_terminal                            
                        AND TA.exercicio_boletim  = TF.exercicio_boletim                             
                        AND TA.cod_entidade       = TF.cod_entidade                                  
                        AND TA.cod_boletim        = TF.cod_boletim         )                         
                LEFT JOIN tesouraria.terminal_desativado AS TTD                                      
                ON(                                                                                  
                    TT.cod_terminal       = TTD.cod_terminal                                         
                AND TT.timestamp_terminal = TTD.timestamp_terminal )                                 
                INNER JOIN tesouraria.usuario_terminal AS TUT                                        
                ON(                                                                                  
                    TT.cod_terminal       = TUT.cod_terminal                                         
                AND TT.timestamp_terminal = TUT.timestamp_terminal                                   
                )                                                                                    
                INNER JOIN sw_cgm AS CGM                                                             
                ON( TUT.cgm_usuario       = CGM.numcgm             )                                 
                 WHERE  TA.exercicio_boletim = :exercicio_boletim AND  TA.cod_entidade IN( :cod_entidade ) 
                 AND  TTD.timestamp_desativado IS NULL 
                 AND  TF.timestamp_fechamento IS NOT NULL 
                 AND  TF.timestamp_fechamento >= TA.timestamp_abertura 
                 AND  TT.cod_terminal = :cod_terminal ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_terminal', $codTerminal);
        $query->bindValue('exercicio_boletim', $exercicioBoletim);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->execute();
        return $query->fetch();
    }
}
