<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class EventoComplementarCalculadoRepository extends ORM\EntityRepository
{
    /**
     * @param $filtro
     * @param $entidade
     *
     * @return array
     */
    public function montaRecuperaEventosCalculados($filtro, $entidade)
    {
        $stSql = "SELECT registro_evento_parcela.parcela as quantidade_parc                                      
             , evento_calculado.valor                                                                   
             , evento_calculado.quantidade                                                              
             , evento_calculado.cod_registro                                                            
             , ( CASE WHEN evento_calculado.desdobramento IS NOT NULL                                   
                         THEN evento.descricao ||' '|| getDesdobramentoSalario(evento_calculado.desdobramento,'" . $entidade . "') 
                         ELSE evento.descricao                                                          
               END ) as descricao                                                                       
             , evento.descricao as nom_evento                                                           
             , evento.cod_evento                                                                        
             , evento.codigo                                                                            
             , evento.natureza                                                                          
             , evento.apresentar_contracheque                                                           
             , evento_calculado.desdobramento                                                           
             , getDesdobramentoSalario(evento_calculado.desdobramento,'" . $entidade . "') as desdobramento_texto           
          FROM folhapagamento.ultimo_registro_evento                                                    
           INNER JOIN folhapagamento.registro_evento                                                    
                 ON ultimo_registro_evento.cod_evento = registro_evento.cod_evento                      
                AND ultimo_registro_evento.cod_registro = registro_evento.cod_registro                  
                AND ultimo_registro_evento.timestamp = registro_evento.timestamp                        
         INNER JOIN folhapagamento.registro_evento_periodo                                              
                 ON registro_evento.cod_registro = registro_evento_periodo.cod_registro                 
         INNER JOIN folhapagamento.evento_calculado                                                     
                 ON ultimo_registro_evento.cod_evento = evento_calculado.cod_evento                     
                AND ultimo_registro_evento.cod_registro = evento_calculado.cod_registro                 
                AND ultimo_registro_evento.timestamp = evento_calculado.timestamp_registro              
          LEFT JOIN folhapagamento.registro_evento_parcela                                              
                 ON ultimo_registro_evento.cod_evento = registro_evento_parcela.cod_evento              
                AND ultimo_registro_evento.cod_registro = registro_evento_parcela.cod_registro          
                AND ultimo_registro_evento.timestamp = registro_evento_parcela.timestamp                
         INNER JOIN folhapagamento.evento                                                               
                 ON evento_calculado.cod_evento = evento.cod_evento                                     
         WHERE 1=1";

        if ($filtro) {
            $stSql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     *
     * @return array
     */
    public function montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select * from recuperaValoresAcumuladosCalculoComplementar(
    " . $codContrato . ",
    " . $codPeriodoMovimentacao . ",
    " . $numCgm . ",
    '" . $natureza . "',
    '" . $entidade . "'
    )  order by codigo";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }


    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     *
     * @return array
     */
    public function montaRecuperaRotuloValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select recuperaRotuloValoresAcumuladosCalculoComplementar(
     " . $codContrato . ",
    " . $codPeriodoMovimentacao . ",
    " . $numCgm . ",
    '" . $natureza . "',
    '" . $entidade . "'
    ) as rotulo";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $filtro
     *
     * @return array
     */
    public function recuperaEventoComplementarCalculadoParaRelatorio($filtro)
    {
        $stSql = "SELECT evento_complementar_calculado.*                                                                       
         , evento.descricao                                                                                      
         , evento.codigo                                                                                         
         , evento.natureza                                                                                       
         , sequencia_calculo.sequencia                                                                           
         , registro_evento_complementar.cod_complementar                                                         
      FROM folhapagamento.evento_complementar_calculado                                                          
         , folhapagamento.registro_evento_complementar                                                           
         , folhapagamento.ultimo_registro_evento_complementar                                                    
         , folhapagamento.evento                                                                                 
         , folhapagamento.sequencia_calculo_evento                                                               
         , folhapagamento.sequencia_calculo                                                                      
     WHERE registro_evento_complementar.cod_registro     = ultimo_registro_evento_complementar.cod_registro      
       AND registro_evento_complementar.cod_evento       = ultimo_registro_evento_complementar.cod_evento        
       AND registro_evento_complementar.cod_configuracao = ultimo_registro_evento_complementar.cod_configuracao  
       AND registro_evento_complementar.timestamp        = ultimo_registro_evento_complementar.timestamp         
       AND registro_evento_complementar.cod_registro     = evento_complementar_calculado.cod_registro            
       AND registro_evento_complementar.cod_evento       = evento_complementar_calculado.cod_evento              
       AND registro_evento_complementar.cod_configuracao = evento_complementar_calculado.cod_configuracao        
       AND registro_evento_complementar.timestamp        = evento_complementar_calculado.timestamp_registro      
       AND evento_complementar_calculado.cod_evento = evento.cod_evento                                          
       AND evento_complementar_calculado.cod_evento = sequencia_calculo_evento.cod_evento                        
       AND sequencia_calculo_evento.cod_sequencia = sequencia_calculo.cod_sequencia";

        if ($filtro) {
            $stSql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param null $filtro
     * @param null $ordem
     * @return object
     */
    public function recuperaEventoComplementarCalculado($filtro = null, $ordem = null)
    {
        $sql = " SELECT evento_complementar_calculado.*                                                                          
             , ( CASE WHEN evento_complementar_calculado.desdobramento IS NOT NULL                                      
                         THEN evento.descricao||' '||getDesdobramentoFolha(evento_complementar_calculado.cod_configuracao,evento_complementar_calculado.desdobramento,'') 
                         ELSE evento.descricao                                                                          
                 END ) AS descricao                                                                                     
             , evento.descricao as nom_evento                                                                           
             , evento.codigo                                                                                            
             , evento.natureza                                                                                          
             , getDesdobramentoFolha(evento_complementar_calculado.cod_configuracao,evento_complementar_calculado.desdobramento,'') as desdobramento_texto 
        FROM folhapagamento.registro_evento_complementar                                                              
             , folhapagamento.ultimo_registro_evento_complementar                                                       
             , folhapagamento.evento_complementar_calculado                                                             
             , folhapagamento.evento                                                                                    
        WHERE registro_evento_complementar.cod_registro = ultimo_registro_evento_complementar.cod_registro             
           AND registro_evento_complementar.cod_evento   = ultimo_registro_evento_complementar.cod_evento               
           AND registro_evento_complementar.timestamp    = ultimo_registro_evento_complementar.timestamp                
           AND registro_evento_complementar.cod_configuracao = ultimo_registro_evento_complementar.cod_configuracao     
           AND ultimo_registro_evento_complementar.cod_registro = evento_complementar_calculado.cod_registro            
           AND ultimo_registro_evento_complementar.cod_evento   = evento_complementar_calculado.cod_evento              
           AND ultimo_registro_evento_complementar.timestamp    = evento_complementar_calculado.timestamp_registro      
           AND ultimo_registro_evento_complementar.cod_configuracao = evento_complementar_calculado.cod_configuracao    
           AND evento_complementar_calculado.cod_evento = evento.cod_evento";

        if ($filtro) {
            $sql .= $filtro;
        }

        $ordem = $ordem ? " ORDER BY ".$ordem : " ORDER BY descricao ";
        $sql .= $ordem;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
