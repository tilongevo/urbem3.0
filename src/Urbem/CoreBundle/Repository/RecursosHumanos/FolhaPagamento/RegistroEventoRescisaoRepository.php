<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Repository\AbstractRepository;

class RegistroEventoRescisaoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $entidade
     * @param $anoMesCompetencia
     * @param bool $stFiltro
     * @return array
     */
    public function recuperaContratosDoFiltro($exercicio, $entidade, $anoMesCompetencia, $stFiltro = false, $ativo = false)
    {
        $sql = "
        SELECT contrato.*                                                                                                                                                                        
           , servidor.numcgm                                                                                                                                                                   
           , sw_cgm.nom_cgm                                                                                                                                                                    
           , recuperaDescricaoOrgao(orgao.cod_orgao, '" . $exercicio . "-01-01') as descricao_lotacao                                                                                  
           , vw_orgao_nivel.orgao as cod_estrutural                                                                                                                                            
           , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato,0,'" . $entidade . "') as situacao 
           , servidor.cod_cargo                                                                                                                                                                
           , servidor.cod_sub_divisao                                                                                                                                                          
           , servidor.cod_especialidade_cargo as cod_especialidade                                                                                                                             
        FROM pessoal.contrato                                                                                                                                         
           , (SELECT servidor_contrato_servidor.cod_contrato                                                                                                                                   
                   , servidor.numcgm                                                                                                                                                           
                   , contrato_servidor_orgao.cod_orgao                                                                                                                                         
                   , contrato_servidor.ativo                                                                                                                                                   
                   , contrato_servidor.cod_cargo                                                                                                                                               
                   , contrato_servidor.cod_sub_divisao                                                                                                                                         
                   , contrato_servidor_especialidade_cargo.cod_especialidade as cod_especialidade_cargo                                                                                        
                   , contrato_servidor_funcao.cod_cargo as cod_funcao                                                                                                                          
                   , contrato_servidor_especialidade_funcao.cod_especialidade_funcao                                                                                                           
                   , contrato_servidor_local.cod_local                                                                                                                                         
                   , contrato_servidor_padrao.cod_padrao                                                                                                                                       
                FROM pessoal.servidor_contrato_servidor                                                                                                               
                   , pessoal.servidor                                                                                                                                 
                   , pessoal.contrato_servidor_orgao                                                                                                                  
                   , (  SELECT cod_contrato                                                                                                                                                    
                             , max(timestamp) as timestamp                                                                                                                                     
                          FROM pessoal.contrato_servidor_orgao                                                                                                                                 
                      GROUP BY cod_contrato) as max_contrato_servidor_orgao                                                                                                                    
                   , pessoal.contrato_servidor_funcao                                                                                                                                          
                   , (  SELECT cod_contrato                                                                                                                                                    
                             , max(timestamp) as timestamp                                                                                                                                     
                          FROM pessoal.contrato_servidor_funcao                                                                                                                                
                      GROUP BY cod_contrato) as max_contrato_servidor_funcao                                                                                                                   
                   , pessoal.contrato_servidor_padrao                                                                                                                                          
                   , (  SELECT cod_contrato                                                                                                                                                    
                             , max(timestamp) as timestamp                                                                                                                                     
                          FROM pessoal.contrato_servidor_padrao                                                                                                                                
                      GROUP BY cod_contrato) as max_contrato_servidor_padrao                                                                                                                   
                   , pessoal.contrato_servidor                                                                                                                                                 
           LEFT JOIN pessoal.contrato_servidor_especialidade_cargo                                                                                                                             
                  ON contrato_servidor.cod_contrato = contrato_servidor_especialidade_cargo.cod_contrato                                                                                       
           LEFT JOIN (SELECT contrato_servidor_especialidade_funcao.cod_especialidade as cod_especialidade_funcao                                                                              
                           , contrato_servidor_especialidade_funcao.cod_contrato                                                                                                               
                        FROM pessoal.contrato_servidor_especialidade_funcao                                                                                                                    
                           , (SELECT cod_contrato                                                                                                                                              
                                   , max(timestamp) as timestamp                                                                                                                               
                                FROM pessoal.contrato_servidor_especialidade_funcao                                                                                                            
                              GROUP BY cod_contrato) max_contrato_servidor_especialidade_funcao                                                                                                
                       WHERE contrato_servidor_especialidade_funcao.cod_contrato = max_contrato_servidor_especialidade_funcao.cod_contrato                                                     
                         AND contrato_servidor_especialidade_funcao.timestamp = max_contrato_servidor_especialidade_funcao.timestamp) as contrato_servidor_especialidade_funcao                
                  ON contrato_servidor.cod_contrato = contrato_servidor_especialidade_funcao.cod_contrato                                                                                      
           LEFT JOIN (SELECT contrato_servidor_local.cod_local                                                                                                                                 
                           , contrato_servidor_local.cod_contrato                                                                                                                              
                        FROM pessoal.contrato_servidor_local                                                                                                                                   
                           , (SELECT cod_contrato                                                                                                                                              
                                   , max(timestamp) as timestamp                                                                                                                               
                                FROM pessoal.contrato_servidor_local                                                                                                                           
                              GROUP BY cod_contrato) max_contrato_servidor_local                                                                                                               
                       WHERE contrato_servidor_local.cod_contrato = max_contrato_servidor_local.cod_contrato                                                                                   
                         AND contrato_servidor_local.timestamp = max_contrato_servidor_local.timestamp) as contrato_servidor_local                                                             
                  ON contrato_servidor.cod_contrato = contrato_servidor_local.cod_contrato                                                                                                     
               WHERE servidor_contrato_servidor.cod_servidor = servidor.cod_servidor                                                                                                           
                 AND servidor_contrato_servidor.cod_contrato = contrato_servidor_orgao.cod_contrato                                                                                            
                 AND contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato                                                                                           
                 AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp                                                                                                 
                 AND servidor_contrato_servidor.cod_contrato = contrato_servidor_funcao.cod_contrato                                                                                           
                 AND contrato_servidor_funcao.cod_contrato = max_contrato_servidor_funcao.cod_contrato                                                                                         
                 AND contrato_servidor_funcao.timestamp = max_contrato_servidor_funcao.timestamp                                                                                               
                 AND servidor_contrato_servidor.cod_contrato = contrato_servidor.cod_contrato                                                                                                  
                 AND servidor_contrato_servidor.cod_contrato = contrato_servidor_padrao.cod_contrato                                                                                           
                 AND contrato_servidor_padrao.cod_contrato = max_contrato_servidor_padrao.cod_contrato                                                                                         
                 AND contrato_servidor_padrao.timestamp = max_contrato_servidor_padrao.timestamp                                                                                               
               UNION                                                                                                                                                                           
              SELECT contrato_pensionista.cod_contrato                                                                                                                                         
                   , pensionista.numcgm                                                                                                                                                        
                   , contrato_pensionista_orgao.cod_orgao                                                                                                                                      
                   , false as ativo                                                                                                                                                            
                   , contrato_servidor.cod_cargo                                                                                                                                               
                   , contrato_servidor.cod_sub_divisao                                                                                                                                         
                   , contrato_servidor_especialidade_cargo.cod_especialidade as cod_especialidade_cargo                                                                                        
                   , 0 as cod_funcao                                                                                                                                                           
                   , 0 as cod_especialidade_funcao                                                                                                                                             
                   , 0 as cod_local                                                                                                                                                            
                   , 0 as cod_padrao                                                                                                                                                           
                FROM pessoal.contrato_pensionista                                                                                                                                              
                   , pessoal.pensionista                                                                                                                                                       
                   , pessoal.contrato_pensionista_orgao                                                                                                                                        
                   , (  SELECT cod_contrato                                                                                                                                                    
                             , max(timestamp) as timestamp                                                                                                                                     
                          FROM pessoal.contrato_pensionista_orgao                                                                                                                              
                      GROUP BY cod_contrato) as max_contrato_pensionista_orgao                                                                                                                 
                   , pessoal.contrato_servidor                                                                                                                                                 
           LEFT JOIN pessoal.contrato_servidor_especialidade_cargo                                                                                                                             
                  ON contrato_servidor.cod_contrato = contrato_servidor_especialidade_cargo.cod_contrato                                                                                       
               WHERE contrato_pensionista.cod_pensionista = pensionista.cod_pensionista                                                                                                        
                 AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente                                                                                              
                 AND contrato_pensionista.cod_contrato = contrato_pensionista_orgao.cod_contrato                                                                                               
                 AND contrato_pensionista_orgao.cod_contrato = max_contrato_pensionista_orgao.cod_contrato                                                                                     
                 AND contrato_pensionista_orgao.timestamp = max_contrato_pensionista_orgao.timestamp                                                                                           
                 AND contrato_pensionista.cod_contrato_cedente = contrato_servidor.cod_contrato) as servidor                                                                                   
           , sw_cgm                                                                                                                                                                            
           , organograma.orgao                                                                                                                                                                 
           , organograma.orgao_nivel                                                                                                                                                           
           , organograma.organograma                                                                                                                                                           
           , organograma.nivel                                                                                                                                                                 
           , organograma.vw_orgao_nivel                                                                                                                                                        
       WHERE contrato.cod_contrato = servidor.cod_contrato                                                                                                                                     
         AND servidor.numcgm = sw_cgm.numcgm                                                                                                                                                   
         AND servidor.cod_orgao = orgao.cod_orgao                                                                                                                                              
         AND orgao.cod_orgao = orgao_nivel.cod_orgao                                                                                                                                           
         AND orgao_nivel.cod_nivel = nivel.cod_nivel                                                                                                                                           
         AND orgao_nivel.cod_organograma = nivel.cod_organograma                                                                                                                               
         AND nivel.cod_organograma = organograma.cod_organograma                                                                                                                               
         AND orgao_nivel.cod_nivel = vw_orgao_nivel.nivel                                                                                                                                      
         AND organograma.cod_organograma = vw_orgao_nivel.cod_organograma                                                                                                                      
         AND orgao.cod_orgao = vw_orgao_nivel.cod_orgao
";

        if (is_numeric($stFiltro)) {
            $sql .= "
           AND registro = :filtro 
            ";
        } else {
            $sql .= "
            AND lower (nom_cgm)
            LIKE lower (:filtro)
            || '%'
            ";
        }

        if (!$ativo) {
            $sql .= " AND recuperarSituacaoDoContratoLiteral(contrato.cod_contrato,0,'" . $entidade . "') = 'Ativo'";
        } else {
            $sql .= " AND recuperarSituacaoDoContratoLiteral(contrato.cod_contrato,0,'" . $entidade . "') = '.$ativo.'";
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($stFiltro)) {
            $query->bindValue(":filtro", $stFiltro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . $stFiltro . "%", \PDO::PARAM_STR);
        }

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codContrato
     * @param $periodoMovimentacao
     * @return array
     */
    public function montaRecuperaRelacionamento($codContrato, $periodoMovimentacao, $entidade = '')
    {
        $sql = "
SELECT registro_evento_rescisao.cod_registro                                                           
         , registro_evento_rescisao.timestamp                                                              
         , registro_evento_rescisao.cod_evento                                                             
         , registro_evento_rescisao.cod_contrato                                                           
         , registro_evento_rescisao.cod_periodo_movimentacao                                               
         , registro_evento_rescisao.valor                                                                  
         , registro_evento_rescisao.quantidade                                                             
         , registro_evento_rescisao.desdobramento                                                          
         , getDesdobramentoRescisao(registro_evento_rescisao.desdobramento,'".$entidade."') as desdobramento_texto         
         , CASE WHEN registro_evento_rescisao.automatico = 't' THEN 'Sim'                                  
           ELSE 'Não' END as automatico                                                                    
         , evento.codigo                                                                                   
         , evento.evento_sistema                                                                           
         , trim(evento.descricao) as descricao                                                             
         , registro_evento_rescisao_parcela.parcela                                                        
      FROM folhapagamento.registro_evento_rescisao                                                         
         , folhapagamento.ultimo_registro_evento_rescisao                                                  
    LEFT JOIN folhapagamento.registro_evento_rescisao_parcela                                              
           ON registro_evento_rescisao_parcela.cod_evento = ultimo_registro_evento_rescisao.cod_evento       
          AND registro_evento_rescisao_parcela.cod_registro = ultimo_registro_evento_rescisao.cod_registro   
          AND registro_evento_rescisao_parcela.timestamp = ultimo_registro_evento_rescisao.timestamp         
          AND registro_evento_rescisao_parcela.desdobramento = ultimo_registro_evento_rescisao.desdobramento 
         , folhapagamento.evento                                                                         
     WHERE registro_evento_rescisao.cod_evento = evento.cod_evento                                    
       AND registro_evento_rescisao.cod_registro = ultimo_registro_evento_rescisao.cod_registro              
       AND registro_evento_rescisao.cod_evento = ultimo_registro_evento_rescisao.cod_evento                  
       AND registro_evento_rescisao.timestamp = ultimo_registro_evento_rescisao.timestamp                    
       AND registro_evento_rescisao.desdobramento = ultimo_registro_evento_rescisao.desdobramento  
      AND cod_contrato = $codContrato
 AND cod_periodo_movimentacao = $periodoMovimentacao 
 AND evento.natureza != 'B' order by descricao;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codEvento
     * @return int
     */
    public function getNextCodRegistro($codEvento)
    {
        return $this->nextVal('cod_registro', ['cod_evento' => $codEvento]);
    }

    /**
     * @param $codContrato
     * @return array
     */
    public function recuperaRegistrosEventosDoContrato($codContrato)
    {
        $sql = "SELECT to_real(registro_evento_rescisao.valor) as valor                                                                                               
         , to_real(registro_evento_rescisao.quantidade) as quantidade                                                                                      
         , (select registro from pessoal.contrato where cod_contrato = registro_evento_rescisao.cod_contrato) as matricula        
         , registro_evento_rescisao.cod_contrato                                                                                                            
         , servidor.numcgm                                                                                                                                  
         , ( case when registro_evento_rescisao.desdobramento = 'S'  then 'Saldo Salário'                                                                   
                  when registro_evento_rescisao.desdobramento = 'A'  then 'Aviso Prêvio Indenizado'                                                         
                  when registro_evento_rescisao.desdobramento = 'V'  then 'Férias Vencidas'                                                                 
                  when registro_evento_rescisao.desdobramento = 'P'  then 'Férias Proporcionais'                                                            
                  when registro_evento_rescisao.desdobramento = 'D'  then '13º Salário'                                                                     
            end ) as descricao                                                                                                                              
         , registro_evento_rescisao.cod_periodo_movimentacao                                                                                                
         , (select nom_cgm from sw_cgm where numcgm = servidor.numcgm) as nom_cgm
         , folhapagamento.evento.cod_evento
     FROM folhapagamento.registro_evento_rescisao                                                                                 
         , folhapagamento.ultimo_registro_evento_rescisao                                                                         
         , pessoal.servidor_contrato_servidor                                                                                     
         , pessoal.servidor                                                                                                       
         , folhapagamento.evento                                                                                                  
    WHERE registro_evento_rescisao.cod_registro = ultimo_registro_evento_rescisao.cod_registro                                                              
      AND registro_evento_rescisao.timestamp = ultimo_registro_evento_rescisao.timestamp                                                                    
      AND registro_evento_rescisao.cod_evento = ultimo_registro_evento_rescisao.cod_evento                                                                  
      AND registro_evento_rescisao.desdobramento = ultimo_registro_evento_rescisao.desdobramento                                                            
      AND registro_evento_rescisao.cod_contrato = servidor_contrato_servidor.cod_contrato                                                                   
      AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor                                                                                   
      AND registro_evento_rescisao.cod_evento = evento.cod_evento and registro_evento_rescisao.cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $anoMesCompetencia
     * @param bool $stFiltro
     * @param bool $ativo
     * @return array
     */
    public function recuperaRescisaoContratoPensionista($exercicio, $entidade, $anoMesCompetencia, $stFiltro = false, $ativo = false)
    {
        $sql = "SELECT contrato.*                                                                                                                                                   
            , pensionista.numcgm                                                                                                                                         
            , sw_cgm.nom_cgm                                                                                                                                             
            , recuperaDescricaoOrgao(orgao.cod_orgao, '".$exercicio."-01-01') as descricao_lotacao                                                           
            , vw_orgao_nivel.orgao as cod_estrutural                                                                                                                     
            , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato,0,'".$entidade."') as situacao                                                        
            , contrato_servidor.cod_cargo                                                                                                                                
            , contrato_servidor.cod_sub_divisao                                                                                                                          
            , contrato_servidor_especialidade_cargo.cod_especialidade                                                                                                    
            , causa_rescisao.descricao as descricao_causa                                                                                                                
            , causa_rescisao.num_causa                                                                                                                                   
            , to_char(contrato_pensionista_caso_causa.dt_rescisao,'dd/mm/yyyy') as dt_rescisao                                                                           
     FROM pessoal".$entidade.".contrato                                                                                                                      
            , pessoal".$entidade.".contrato_servidor                                                                                                         
            , pessoal".$entidade.".pensionista                                                                                                               
            , pessoal".$entidade.".contrato_pensionista                                                                                                      
     INNER JOIN (SELECT contrato_servidor_padrao.cod_contrato                                                                                                            
                     , contrato_servidor_padrao.cod_padrao                                                                                                               
                  FROM pessoal".$entidade.".contrato_servidor_padrao                                                                                         
                     , (  SELECT cod_contrato                                                                                                                            
                               , max(timestamp) as timestamp                                                                                                             
                           FROM pessoal".$entidade.".contrato_servidor_padrao                                                                                
                          GROUP BY cod_contrato) as max_contrato_servidor_padrao                                                                                         
                 WHERE contrato_servidor_padrao.cod_contrato = max_contrato_servidor_padrao.cod_contrato                                                                 
                   AND contrato_servidor_padrao.timestamp = max_contrato_servidor_padrao.timestamp) as contrato_servidor_padrao                                          
            ON pessoal".$entidade.".contrato_pensionista.cod_contrato_cedente = contrato_servidor_padrao.cod_contrato                                        
     LEFT JOIN (SELECT contrato_servidor_local.cod_contrato                                                                                                              
                     , contrato_servidor_local.cod_local                                                                                                                 
                  FROM pessoal".$entidade.".contrato_servidor_local                                                                                          
                     , (  SELECT cod_contrato                                                                                                                            
                               , max(timestamp) as timestamp                                                                                                             
                           FROM pessoal".$entidade.".contrato_servidor_local                                                                                 
                          GROUP BY cod_contrato) as max_contrato_servidor_local                                                                                          
                 WHERE contrato_servidor_local.cod_contrato = max_contrato_servidor_local.cod_contrato                                                                   
                   AND contrato_servidor_local.timestamp = max_contrato_servidor_local.timestamp) as contrato_servidor_local                                             
            ON pessoal".$entidade.".contrato_pensionista.cod_contrato_cedente = contrato_servidor_local.cod_contrato                                         
     LEFT JOIN pessoal".$entidade.".contrato_servidor_especialidade_cargo                                                                                    
            ON pessoal".$entidade.".contrato_pensionista.cod_contrato_cedente = contrato_servidor_especialidade_cargo.cod_contrato                           
     LEFT JOIN (SELECT contrato_servidor_especialidade_funcao.cod_contrato                                                                                               
                     , contrato_servidor_especialidade_funcao.cod_especialidade                                                                                          
                FROM pessoal".$entidade.".contrato_servidor_especialidade_funcao                                                                             
                     , (  SELECT cod_contrato                                                                                                                            
                               , max(timestamp) as timestamp                                                                                                             
                           FROM pessoal".$entidade.".contrato_servidor_especialidade_funcao                                                                  
                          GROUP BY cod_contrato) as max_contrato_servidor_especialidade_funcao                                                                           
                WHERE contrato_servidor_especialidade_funcao.cod_contrato = max_contrato_servidor_especialidade_funcao.cod_contrato                                      
                  AND contrato_servidor_especialidade_funcao.timestamp = max_contrato_servidor_especialidade_funcao.timestamp) as contrato_servidor_especialidade_funcao 
            ON pessoal".$entidade.".contrato_pensionista.cod_contrato_cedente = contrato_servidor_especialidade_funcao.cod_contrato                          
             , sw_cgm                                                                                                                                                    
             , pessoal".$entidade.".contrato_pensionista_orgao                                                                                               
             , (  SELECT cod_contrato                                                                                                                                    
                       , max(timestamp) as timestamp                                                                                                                     
                   FROM pessoal".$entidade.".contrato_pensionista_orgao                                                                                      
                  GROUP BY cod_contrato) as max_contrato_pensionista_orgao                                                                                               
             , organograma.orgao                                                                                                                                         
             , organograma.orgao_nivel                                                                                                                                   
             , organograma.organograma                                                                                                                                   
             , organograma.nivel                                                                                                                                         
             , organograma.vw_orgao_nivel                                                                                                                                
             , pessoal".$entidade.".contrato_servidor_funcao                                                                                                 
             , (  SELECT cod_contrato                                                                                                                                    
                       , max(timestamp) as timestamp                                                                                                                     
                    FROM pessoal".$entidade.".contrato_servidor_funcao                                                                                       
                GROUP BY cod_contrato) as max_contrato_servidor_funcao                                                                                                   
     	, pessoal".$entidade.".contrato_pensionista_caso_causa                                                                                          
             , pessoal".$entidade.".caso_causa                                                                                                               
             , pessoal".$entidade.".causa_rescisao                                                                                                           
         WHERE contrato_pensionista.cod_pensionista = pensionista.cod_pensionista                                                                                        
           AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente                                                                              
           AND pensionista.numcgm = sw_cgm.numcgm                                                                                                                        
           AND contrato.cod_contrato = contrato_pensionista.cod_contrato                                                                                                 
           AND contrato.cod_contrato = contrato_pensionista_orgao.cod_contrato                                                                                           
           AND contrato_pensionista_orgao.cod_contrato = max_contrato_pensionista_orgao.cod_contrato                                                                     
           AND contrato_pensionista_orgao.timestamp = max_contrato_pensionista_orgao.timestamp                                                                           
           AND contrato_pensionista_orgao.cod_orgao = orgao.cod_orgao                                                                                                    
           AND orgao.cod_orgao = orgao_nivel.cod_orgao                                                                                                                   
           AND orgao_nivel.cod_nivel = nivel.cod_nivel                                                                                                                   
           AND orgao_nivel.cod_organograma = nivel.cod_organograma                                                                                                       
           AND nivel.cod_organograma = organograma.cod_organograma                                                                                                       
           AND orgao_nivel.cod_nivel = vw_orgao_nivel.nivel                                                                                                              
           AND organograma.cod_organograma = vw_orgao_nivel.cod_organograma                                                                                              
           AND orgao.cod_orgao = vw_orgao_nivel.cod_orgao                                                                                                                
           AND contrato_pensionista.cod_contrato_cedente = contrato_servidor.cod_contrato                                                                                
           AND contrato_servidor.cod_contrato = contrato_servidor_funcao.cod_contrato                                                                                    
           AND contrato_servidor_funcao.cod_contrato = max_contrato_servidor_funcao.cod_contrato                                                                         
           AND contrato_servidor_funcao.timestamp = max_contrato_servidor_funcao.timestamp                                                                               
           AND contrato.cod_contrato = contrato_pensionista_caso_causa.cod_contrato                                                                                      
           AND contrato_pensionista_caso_causa.cod_caso_causa = caso_causa.cod_caso_causa                                                                                
           AND caso_causa.cod_causa_rescisao = causa_rescisao.cod_causa_rescisao";

        if (is_numeric($stFiltro)) {
            $sql .= "
            AND registro = :filtro
            ";
        } else {
            $sql .= "
            AND lower (nom_cgm)
            LIKE lower (:filtro)
            || '%'
            ";
        }

        if (!$ativo) {
            $sql .= " AND recuperarSituacaoDoContratoLiteral(contrato.cod_contrato,0,'" . $entidade . "') = 'Ativo'";
        } else {
            $sql .= " AND recuperarSituacaoDoContratoLiteral(contrato.cod_contrato,0,'" . $entidade . "') = '.$ativo.'";
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($stFiltro)) {
            $query->bindValue(":filtro", $stFiltro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . $stFiltro . "%", \PDO::PARAM_STR);
        }

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param      $exercicio
     * @param bool $stFiltro
     *
     * @return array
     */
    public function recuperaRescisaoContrato($exercicio, $stFiltro = false)
    {
        $sql = "
SELECT contrato.*                                                                                                                                                 
	        , servidor.numcgm                                                                                                                                            
	        , sw_cgm.nom_cgm                                                                                                                                             
	        , recuperaDescricaoOrgao(orgao.cod_orgao, '".$exercicio."-01-01') as descricao_lotacao                                                           
	        , vw_orgao_nivel.orgao as cod_estrutural                                                                                                                     
	        , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato,0,'') as situacao                                                        
	        , contrato_servidor.cod_cargo                                                                                                                                
	        , contrato_servidor.cod_sub_divisao                                                                                                                          
	        , contrato_servidor_especialidade_cargo.cod_especialidade                                                                                                    
	        , causa_rescisao.descricao as descricao_causa                                                                                                                
	        , causa_rescisao.num_causa                                                                                                                                   
	        , to_char(contrato_servidor_caso_causa.dt_rescisao,'dd/mm/yyyy') as dt_rescisao                                                                              
	     FROM pessoal.contrato                                                                                                                                           
	        , pessoal.contrato_servidor                                                                                                                                  
	INNER JOIN (SELECT contrato_servidor_padrao.cod_contrato                                                                                                             
	                , contrato_servidor_padrao.cod_padrao                                                                                                                
	             FROM pessoal.contrato_servidor_padrao                                                                                                                   
	                , (  SELECT cod_contrato                                                                                                                             
	                          , max(timestamp) as timestamp                                                                                                              
	                       FROM pessoal.contrato_servidor_padrao                                                                                                         
	                   GROUP BY cod_contrato) as max_contrato_servidor_padrao                                                                                            
	            WHERE contrato_servidor_padrao.cod_contrato = max_contrato_servidor_padrao.cod_contrato                                                                  
	              AND contrato_servidor_padrao.timestamp = max_contrato_servidor_padrao.timestamp) as contrato_servidor_padrao                                           
	       ON contrato_servidor.cod_contrato = contrato_servidor_padrao.cod_contrato                                                                                     
	LEFT JOIN (SELECT contrato_servidor_local.cod_contrato                                                                                                               
	                , contrato_servidor_local.cod_local                                                                                                                  
	             FROM pessoal.contrato_servidor_local                                                                                                                    
	                , (  SELECT cod_contrato                                                                                                                             
	                          , max(timestamp) as timestamp                                                                                                              
	                       FROM pessoal.contrato_servidor_local                                                                                                          
	                   GROUP BY cod_contrato) as max_contrato_servidor_local                                                                                             
	            WHERE contrato_servidor_local.cod_contrato = max_contrato_servidor_local.cod_contrato                                                                    
	              AND contrato_servidor_local.timestamp = max_contrato_servidor_local.timestamp) as contrato_servidor_local                                              
	       ON contrato_servidor.cod_contrato = contrato_servidor_local.cod_contrato                                                                                      
	LEFT JOIN pessoal.contrato_servidor_especialidade_cargo                                                                                                              
	       ON contrato_servidor.cod_contrato = contrato_servidor_especialidade_cargo.cod_contrato                                                                        
	LEFT JOIN (SELECT contrato_servidor_especialidade_funcao.cod_contrato                                                                                                
	                , contrato_servidor_especialidade_funcao.cod_especialidade                                                                                           
	             FROM pessoal.contrato_servidor_especialidade_funcao                                                                                                     
	                , (  SELECT cod_contrato                                                                                                                             
	                          , max(timestamp) as timestamp                                                                                                              
	                       FROM pessoal.contrato_servidor_especialidade_funcao                                                                                           
	                   GROUP BY cod_contrato) as max_contrato_servidor_especialidade_funcao                                                                              
	            WHERE contrato_servidor_especialidade_funcao.cod_contrato = max_contrato_servidor_especialidade_funcao.cod_contrato                                      
	              AND contrato_servidor_especialidade_funcao.timestamp = max_contrato_servidor_especialidade_funcao.timestamp) as contrato_servidor_especialidade_funcao 
	       ON contrato_servidor.cod_contrato = contrato_servidor_especialidade_funcao.cod_contrato                                                                       
	        , pessoal.servidor_contrato_servidor                                                                                                                         
	        , pessoal.servidor                                                                                                                                           
	        , sw_cgm                                                                                                                                                     
	        , pessoal.contrato_servidor_orgao                                                                                                                            
	        , (  SELECT cod_contrato                                                                                                                                     
	                  , max(timestamp) as timestamp                                                                                                                      
	               FROM pessoal.contrato_servidor_orgao                                                                                                                  
	           GROUP BY cod_contrato) as max_contrato_servidor_orgao                                                                                                     
	        , organograma.orgao                                                                                                                                          
	        , organograma.orgao_nivel                                                                                                                                    
	        , organograma.organograma                                                                                                                                    
	        , organograma.nivel                                                                                                                                          
	        , organograma.vw_orgao_nivel                                                                                                                                 
	        , pessoal.contrato_servidor_funcao                                                                                                                           
	        , (  SELECT cod_contrato                                                                                                                                     
	                  , max(timestamp) as timestamp                                                                                                                      
	               FROM pessoal.contrato_servidor_funcao                                                                                                                 
	           GROUP BY cod_contrato) as max_contrato_servidor_funcao                                                                                                    
	        , pessoal.contrato_servidor_caso_causa                                                                                                                       
	        , pessoal.caso_causa                                                                                                                                         
	        , pessoal.causa_rescisao                                                                                                                                     
	    WHERE contrato.cod_contrato = servidor_contrato_servidor.cod_contrato                                                                                            
	      AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor                                                                                            
	      AND servidor.numcgm = sw_cgm.numcgm                                                                                                                            
	      AND contrato.cod_contrato = contrato_servidor.cod_contrato                                                                                                     
	      AND contrato.cod_contrato = contrato_servidor_orgao.cod_contrato                                                                                               
	      AND contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato                                                                            
	      AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp                                                                                  
	      AND contrato_servidor_orgao.cod_orgao = orgao.cod_orgao                                                                                                        
	      AND orgao.cod_orgao = orgao_nivel.cod_orgao                                                                                                                    
	      AND orgao_nivel.cod_nivel = nivel.cod_nivel                                                                                                                    
	      AND orgao_nivel.cod_organograma = nivel.cod_organograma                                                                                                        
	      AND nivel.cod_organograma = organograma.cod_organograma                                                                                                        
	      AND orgao_nivel.cod_nivel = vw_orgao_nivel.nivel                                                                                                               
	      AND organograma.cod_organograma = vw_orgao_nivel.cod_organograma                                                                                               
	      AND orgao.cod_orgao = vw_orgao_nivel.cod_orgao                                                                                                                 
	      AND contrato_servidor.cod_contrato = contrato_servidor_funcao.cod_contrato                                                                                     
	      AND contrato_servidor_funcao.cod_contrato = max_contrato_servidor_funcao.cod_contrato                                                                          
	      AND contrato_servidor_funcao.timestamp = max_contrato_servidor_funcao.timestamp                                                                                
	      AND contrato.cod_contrato = contrato_servidor_caso_causa.cod_contrato                                                                                          
	      AND contrato_servidor_caso_causa.cod_caso_causa = caso_causa.cod_caso_causa                                                                                    
	      AND caso_causa.cod_causa_rescisao = causa_rescisao.cod_causa_rescisao ";

        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
}
