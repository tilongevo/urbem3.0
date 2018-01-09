<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Repository\AbstractRepository;

class RegistroEventoFeriasRepository extends AbstractRepository
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
	        , contrato_servidor.cod_cargo                                                                                                                                
	        , contrato_servidor.cod_sub_divisao                                                                                                                          
	        , contrato_servidor_especialidade_cargo.cod_especialidade                                                                                                    
	     FROM pessoal.contrato                                                                                                                  
	        , pessoal.contrato_servidor                                                                                                         
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
	        , pessoal.ferias                                                                                                                                             
	        , pessoal.lancamento_ferias                                                                                                                                  
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
	    WHERE contrato.cod_contrato = servidor_contrato_servidor.cod_contrato                                                                                            
	      AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor                                                                                            
	      AND servidor.numcgm = sw_cgm.numcgm                                                                                                                            
	      AND contrato.cod_contrato = contrato_servidor.cod_contrato                                                                                                     
	      AND contrato.cod_contrato = contrato_servidor_orgao.cod_contrato                                                                                               
	      AND contrato.cod_contrato = ferias.cod_contrato                                                                                                                
	      AND ferias.cod_ferias = lancamento_ferias.cod_ferias                                                                                                           
	      AND (lancamento_ferias.ano_competencia||lancamento_ferias.mes_competencia = '" . $anoMesCompetencia . "'
	      OR                                                                                                                                                             
	      '" . $anoMesCompetencia . "' BETWEEN to_char(lancamento_ferias.dt_inicio,'yyyymm')                                                              
	                                                      AND to_char(lancamento_ferias.dt_fim,'yyyymm'))                                                                
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
	      AND contrato.cod_contrato NOT IN (SELECT cod_contrato                                                                                                          
	                                          FROM pessoal.contrato_servidor_caso_causa ) ";

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
    public function montaRecuperaRelacionamento($filtro = null, $ordem = null)
    {
        $sql = "SELECT registro_evento_ferias.cod_registro                                                           
         , registro_evento_ferias.timestamp                                                              
         , registro_evento_ferias.cod_evento                                                             
         , registro_evento_ferias.cod_contrato                                                           
         , registro_evento_ferias.cod_periodo_movimentacao                                               
         , registro_evento_ferias.valor                                                                  
         , registro_evento_ferias.quantidade                                                             
         , registro_evento_ferias.desdobramento                                                          
         , getDesdobramentoFerias(registro_evento_ferias.desdobramento,'') as desdobramento_texto           
         , CASE WHEN registro_evento_ferias.automatico = 't' THEN 'Sim'                                  
           ELSE 'Não' END as automatico                                                                  
         , evento.codigo                                                                                 
         , evento.evento_sistema                                                                         
         , evento.tipo                                                                                   
         , evento.natureza                                                                               
         , trim(evento.descricao) as descricao                                                           
         , registro_evento_ferias_parcela.parcela                                                        
      FROM folhapagamento.registro_evento_ferias                                                         
         , folhapagamento.ultimo_registro_evento_ferias                                                  
    LEFT JOIN folhapagamento.registro_evento_ferias_parcela                                              
           ON registro_evento_ferias_parcela.cod_evento = ultimo_registro_evento_ferias.cod_evento       
          AND registro_evento_ferias_parcela.cod_registro = ultimo_registro_evento_ferias.cod_registro   
          AND registro_evento_ferias_parcela.timestamp = ultimo_registro_evento_ferias.timestamp         
         , folhapagamento.evento                                                                         
     WHERE registro_evento_ferias.cod_evento = evento.cod_evento                                         
       AND registro_evento_ferias.cod_registro = ultimo_registro_evento_ferias.cod_registro              
       AND registro_evento_ferias.cod_evento = ultimo_registro_evento_ferias.cod_evento                  
       AND registro_evento_ferias.timestamp = ultimo_registro_evento_ferias.timestamp";

        if ($filtro) {
            $sql .= $filtro;
        }

        $sql .= $ordem ? $ordem : ' order by descricao;';

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
        $sql = "SELECT ultimo_registro_evento_ferias.*                                                      
         , registro_evento_ferias.cod_contrato                                                  
      FROM folhapagamento.ultimo_registro_evento_ferias                                         
         , folhapagamento.registro_evento_ferias                                                
     WHERE ultimo_registro_evento_ferias.cod_registro = registro_evento_ferias.cod_registro     
       AND ultimo_registro_evento_ferias.cod_evento = registro_evento_ferias.cod_evento         
       AND ultimo_registro_evento_ferias.timestamp = registro_evento_ferias.timestamp and cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $filtro
     * @return array
     */
    public function recuperaRegistrosEventosFerias($filtro)
    {
        if (isset($filtro['tipo']) && $filtro['tipo'] == 'soma') {
            $select = "select sum(valor) as totalValor, sum(quantidade) as totalQuantidade ";
            $orderBy = "";
        } else {
            $select = "select
                    to_real(registro_evento_ferias.valor) as valor,
                    to_real(registro_evento_ferias.quantidade) as quantidade,
                    (
                        select
                            registro
                        from
                            pessoal.contrato
                        where
                            cod_contrato = registro_evento_ferias.cod_contrato
                    ) as matricula,
                    registro_evento_ferias.cod_contrato,
                    servidor.numcgm,
                    (
                        case
                            when registro_evento_ferias.desdobramento = 'A' then 'Abono'
                            when registro_evento_ferias.desdobramento = 'F' then 'Férias'
                            when registro_evento_ferias.desdobramento = 'D' then 'Adiantamento'
                        end
                    ) as descricao,
                    registro_evento_ferias.cod_periodo_movimentacao,
                    (
                        select
                            nom_cgm
                        from
                            sw_cgm
                        where
                            numcgm = servidor.numcgm
                    ) as nom_cgm";

            $orderBy = "order by nom_cgm";
        }

        $andWhere = '';
        if (isset($filtro['codContrato']) && $filtro['codContrato'] != '') {
            $andWhere .= " and registro_evento_ferias.cod_contrato = ".$filtro['codContrato'];
        }

        if (isset($filtro['codEvento']) && $filtro['codEvento'] != '') {
            $andWhere .= " and registro_evento_ferias.cod_evento = ".$filtro['codEvento'];
        }

        if (isset($filtro['codPeriodoMovimentacao']) && $filtro['codPeriodoMovimentacao'] != '') {
            $andWhere .= " and registro_evento_ferias.cod_periodo_movimentacao = ".$filtro['codPeriodoMovimentacao'];
        }

        $sql = $select."
                from
                    folhapagamento.registro_evento_ferias,
                    folhapagamento.ultimo_registro_evento_ferias,
                    pessoal.servidor_contrato_servidor,
                    pessoal.servidor,
                    folhapagamento.evento
                where
                    registro_evento_ferias.cod_registro = ultimo_registro_evento_ferias.cod_registro
                    and registro_evento_ferias.timestamp = ultimo_registro_evento_ferias.timestamp
                    and registro_evento_ferias.cod_evento = ultimo_registro_evento_ferias.cod_evento
                    and registro_evento_ferias.desdobramento = ultimo_registro_evento_ferias.desdobramento
                    and registro_evento_ferias.cod_contrato = servidor_contrato_servidor.cod_contrato
                    and servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                    and registro_evento_ferias.cod_evento = evento.cod_evento
                    ".$andWhere
                     .$orderBy;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $filtro
     * @return array
     */
    public function recuperaBaseCalculos($filtro)
    {
        $sql = "select
                    evento_base.cod_evento,
                    evento_base.cod_evento_base,
                    evento_base.cod_caso,
                    evento_base.cod_configuracao,
                    TO_CHAR(
                        evento_base.timestamp,
                        'yyyy-mm-dd hh24:mi:ss.us'
                    ) as timestamp,
                    evento_base.cod_caso_base,
                    evento_base.cod_configuracao_base,
                    TO_CHAR(
                        evento_base.timestamp_base,
                        'yyyy-mm-dd hh24:mi:ss.us'
                    ) as timestamp_base,
                    trim( evento.descricao ) as descricao_base,
                    (evento.codigo) as codigo_base,
                    getDesdobramentoFerias(
                        registro_evento_ferias.desdobramento,
                        ''
                    ) as desdobramento_texto
                from
                    folhapagamento.evento_base,
                    (
                        select
                            cod_evento_base,
                            cod_evento,
                            cod_configuracao_base,
                            cod_configuracao,
                            max( timestamp_base ) as timestamp_base,
                            max( timestamp ) as timestamp
                        from
                            folhapagamento.evento_base
                        group by
                            cod_evento_base,
                            cod_evento,
                            cod_configuracao_base,
                            cod_configuracao
                        order by
                            cod_evento_base
                    ) as max_evento_base,
                    folhapagamento.evento,
                    folhapagamento.registro_evento_ferias,
                    folhapagamento.ultimo_registro_evento_ferias
                where
                    evento_base.cod_evento_base = max_evento_base.cod_evento_base
                    and evento_base.timestamp_base = max_evento_base.timestamp_base
                    and evento_base.cod_evento = max_evento_base.cod_evento
                    and evento_base.timestamp = max_evento_base.timestamp
                    and evento_base.cod_configuracao_base = max_evento_base.cod_configuracao_base
                    and evento_base.cod_configuracao = max_evento_base.cod_configuracao
                    and evento_base.cod_evento_base = evento.cod_evento
                    and registro_evento_ferias.cod_evento = ultimo_registro_evento_ferias.cod_evento
                    and registro_evento_ferias.cod_registro = ultimo_registro_evento_ferias.cod_registro
                    and registro_evento_ferias.timestamp = ultimo_registro_evento_ferias.timestamp
                    and registro_evento_ferias.desdobramento = ultimo_registro_evento_ferias.desdobramento
                    and registro_evento_ferias.cod_evento = evento.cod_evento
                    and evento_base.cod_evento in(".$filtro['codEventos'].")
                    and evento_base.cod_configuracao = ".$filtro['codConfiguracao']."
                    and registro_evento_ferias.cod_contrato = ".$filtro['codContrato']."
                    and registro_evento_ferias.cod_periodo_movimentacao = ".$filtro['codPeriodoMovimentacao']."
                order by
                    cod_evento_base;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
