<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class LogErroCalculoDecimoRepository extends ORM\EntityRepository
{
    /**
     * @param $stFiltro
     *
     * @return mixed
     */
    public function recuperaLogErroCalculo($stFiltro)
    {
        $sql = <<<SQL
SELECT log_erro_calculo.*                       
        , (SELECT codigo FROM folhapagamento.evento WHERE cod_evento = log_erro_calculo.cod_evento) as codigo          
     FROM folhapagamento.log_erro_calculo          
        , folhapagamento.registro_evento           
        , folhapagamento.registro_evento_periodo   
    WHERE log_erro_calculo.cod_evento       = registro_evento.cod_evento       
      AND log_erro_calculo.cod_registro     = registro_evento.cod_registro     
      AND log_erro_calculo.timestamp        = registro_evento.timestamp        
      AND registro_evento.cod_registro      = registro_evento_periodo.cod_registro
SQL;
        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = $query->fetch(\PDO::FETCH_OBJ);
        $result = $queryResult;

        return $result;
    }

    /**
     * @param $stFiltro
     * @param $order
     *
     * @return array
     */
    public function recuperaContratosComErro($stFiltro, $order)
    {
        $sql = <<<SQL
     SELECT contrato.*
             , servidor.numcgm
             , (SELECT nom_cgm FROM sw_cgm WHERE numcgm = servidor.numcgm) as nom_cgm
             , log_erro_calculo_decimo.erro
             , (SELECT codigo FROM folhapagamento.evento WHERE cod_evento = log_erro_calculo_decimo.cod_evento) as codigo
          FROM pessoal.contrato
    INNER JOIN (    SELECT servidor_contrato_servidor.cod_contrato
                         , servidor.numcgm
                      FROM pessoal.servidor_contrato_servidor
                INNER JOIN pessoal.servidor
                        ON servidor.cod_servidor = servidor_contrato_servidor.cod_servidor
                     UNION 
                    SELECT contrato_pensionista.cod_contrato
                         , pensionista.numcgm
                     FROM pessoal.contrato_pensionista
               INNER JOIN pessoal.pensionista
                       ON pensionista.cod_pensionista = contrato_pensionista.cod_pensionista
                      AND pensionista.cod_contrato_cedente = contrato_pensionista.cod_contrato_cedente) as servidor
            ON servidor.cod_contrato = contrato.cod_contrato
    INNER JOIN folhapagamento.registro_evento_decimo
            ON registro_evento_decimo.cod_contrato = contrato.cod_contrato
    INNER JOIN folhapagamento.log_erro_calculo_decimo
            ON log_erro_calculo_decimo.cod_registro = registro_evento_decimo.cod_registro
           AND log_erro_calculo_decimo.cod_evento = registro_evento_decimo.cod_evento
           AND log_erro_calculo_decimo.desdobramento = registro_evento_decimo.desdobramento
           AND log_erro_calculo_decimo.timestamp = registro_evento_decimo.timestamp
SQL;
        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $sql .= " ORDER BY " . $order;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = $query->fetchAll(\PDO::FETCH_OBJ);
        $result = $queryResult;

        return $result;
    }

    /**
     * @param $stFiltro
     *
     * @return array
     */
    public function recuperaRelacionamento($stFiltro)
    {
        $sql = <<<SQL
SELECT log.*                                                                                                        
         , contrato.*                                                                                                   
         , sw_cgm.numcgm                                                                                                
         , sw_cgm.nom_cgm                                                                                               
         , evento.codigo                                                                                                
      FROM folhapagamento.log_erro_calculo as log                                                                       
         , folhapagamento.registro_evento                                                                               
         , folhapagamento.registro_evento_periodo                                                                       
         , folhapagamento.contrato_servidor_periodo                                                                     
         , pessoal.contrato                                                                                             
         , (SELECT contrato_pensionista.cod_contrato                                                                    
                 , pensionista.numcgm                                                                                   
              FROM pessoal.contrato_pensionista                                                                         
                 , pessoal.pensionista                                                                                  
             WHERE contrato_pensionista.cod_pensionista = pensionista.cod_pensionista                                   
               AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente                         
             UNION                                                                                                      
            SELECT servidor_contrato_servidor.cod_contrato                                                              
                 , servidor.numcgm                                                                                      
              FROM pessoal.servidor_contrato_servidor                                                                   
                 , pessoal.servidor                                                                                     
             WHERE servidor_contrato_servidor.cod_servidor = servidor.cod_servidor) as servidor                         
         , sw_cgm_pessoa_fisica                                                                                         
         , sw_cgm                                                                                                       
         , folhapagamento.evento                                                                                        
     WHERE log.cod_evento       = registro_evento.cod_evento                                                            
       AND log.cod_registro     = registro_evento.cod_registro                                                          
       AND log.timestamp        = registro_evento.timestamp                                                             
       AND registro_evento.cod_registro      = registro_evento_periodo.cod_registro                                     
       AND registro_evento_periodo.cod_contrato             = contrato_servidor_periodo.cod_contrato                    
       AND registro_evento_periodo.cod_periodo_movimentacao = contrato_servidor_periodo.cod_periodo_movimentacao        
       AND contrato_servidor_periodo.cod_contrato           = contrato.cod_contrato                                     
       AND servidor.cod_contrato                            = contrato.cod_contrato                                     
       AND servidor.numcgm                   = sw_cgm_pessoa_fisica.numcgm                                              
       AND sw_cgm_pessoa_fisica.numcgm       = sw_cgm.numcgm                                                            
       AND log.cod_evento                    = evento.cod_evento
SQL;
        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = $query->fetchAll(\PDO::FETCH_OBJ);
        $result = $queryResult;

        return $result;
    }
}
