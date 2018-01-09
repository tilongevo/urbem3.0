<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Repository\AbstractRepository;

class RegistroEventoDecimoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $entidade
     * @param $autocomplete
     * @param $stFiltro
     * @param $ativo
     *
     * @return array
     */
    public function recuperaContratosDoFiltro($exercicio, $entidade, $autocomplete, $stFiltro, $ativo)
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

        if ($autocomplete) {
            if (is_numeric($stFiltro)) {
                $sql .= "
             AND (registro = :filtro OR sw_cgm.numcgm = :filtro)
            ";
            } else {
                $sql .= "
            AND lower (nom_cgm)
            LIKE lower (:filtro)
            || '%'
            ";
            }
        } else {
            if ($stFiltro) {
                $sql .= $stFiltro;
            }
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
        if ($autocomplete) {
            if (is_numeric($stFiltro)) {
                $query->bindValue(":filtro", $stFiltro, \PDO::PARAM_INT);
            } else {
                $query->bindValue(":filtro", "%" . $stFiltro . "%", \PDO::PARAM_STR);
            }
        }

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $stFiltro
     * @param $orderBy
     *
     * @return array
     */
    public function montaRecuperaRelacionamento($stFiltro, $orderBy)
    {
        $sql = "
SELECT registro_evento_Decimo.cod_registro                                                           
	     , registro_evento_Decimo.timestamp                                                              
	     , registro_evento_Decimo.cod_evento                                                             
	     , registro_evento_Decimo.cod_contrato                                                           
	     , registro_evento_Decimo.cod_periodo_movimentacao                                               
	     , registro_evento_Decimo.valor                                                                  
	     , registro_evento_Decimo.quantidade                                                             
	     , registro_evento_Decimo.desdobramento                                                          
	     , getDesdobramentoDecimo(registro_evento_Decimo.desdobramento,'') as desdobramento_texto           
	     , CASE WHEN registro_evento_Decimo.automatico = 't' THEN 'Sim'                                  
	       ELSE 'Não' END as automatico                                                                  
	     , evento.codigo                                                                                 
	     , evento.evento_sistema                                                                         
	     , evento.natureza                                                                               
	     , trim(evento.descricao) as descricao                                                           
	     , registro_evento_Decimo_parcela.parcela                                                        
	  FROM folhapagamento.registro_evento_decimo                                                         
	     , folhapagamento.ultimo_registro_evento_decimo                                                  
	LEFT JOIN folhapagamento.registro_evento_Decimo_parcela                                              
	       ON registro_evento_decimo_parcela.cod_evento = ultimo_registro_evento_decimo.cod_evento       
	      AND registro_evento_decimo_parcela.cod_registro = ultimo_registro_evento_decimo.cod_registro   
	      AND registro_evento_decimo_parcela.timestamp = ultimo_registro_evento_decimo.timestamp         
	      AND registro_evento_decimo_parcela.desdobramento = ultimo_registro_evento_decimo.desdobramento 
	     , folhapagamento.evento                                                                         
	 WHERE registro_evento_decimo.cod_evento = evento.cod_evento                                         
	   AND registro_evento_decimo.cod_registro = ultimo_registro_evento_decimo.cod_registro              
	   AND registro_evento_decimo.cod_evento = ultimo_registro_evento_decimo.cod_evento                  
	   AND registro_evento_decimo.timestamp = ultimo_registro_evento_decimo.timestamp                    
	   AND registro_evento_decimo.desdobramento = ultimo_registro_evento_decimo.desdobramento";

        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        if ($orderBy) {
            $sql .= $orderBy;
        } else {
            $sql .= " order by descricao;";
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codEvento
     *
     * @return int
     */
    public function getNextCodRegistro($codEvento)
    {
        return $this->nextVal('cod_registro', ['cod_evento' => $codEvento]);
    }

    /**
     * @param $codContrato
     *
     * @return array
     */
    public function recuperaRegistrosEventosDoContrato($codContrato)
    {
        $sql = "SELECT ultimo_registro_evento_decimo.*                                                      
         , registro_evento_decimo.cod_contrato                                                  
      FROM folhapagamento.ultimo_registro_evento_decimo                                         
         , folhapagamento.registro_evento_decimo                                                
     WHERE ultimo_registro_evento_decimo.cod_registro = registro_evento_decimo.cod_registro     
       AND ultimo_registro_evento_decimo.cod_evento = registro_evento_decimo.cod_evento         
       AND ultimo_registro_evento_decimo.timestamp = registro_evento_decimo.timestamp and cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}
