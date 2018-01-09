<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class AssentamentoGeradoRepository
 *
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class AssentamentoGeradoRepository extends AbstractRepository
{
    public function getNextCodAssentamentoGerado()
    {
        return $this->nextVal('cod_assentamento_gerado');
    }

    /**
     * @return array
     */
    public function recuperaEventosAssentamento($filtro)
    {
        $sql = <<<SQL
  SELECT assentamento_gerado.cod_assentamento                                                                                                
        , assentamento_evento.cod_evento                                                                                         
        , evento.tipo                                                                                                                         
        , periodo_inicial                                                                                                                     
        , periodo_final                                                                                                                       
    FROM pessoal.assentamento_gerado_contrato_servidor                                                              
       , pessoal.assentamento_gerado                                                                                
       , (   SELECT cod_assentamento_gerado                                                                                                   
                  , max(timestamp) as timestamp                                                                                               
               FROM pessoal.assentamento_gerado                                                                     
           GROUP BY cod_assentamento_gerado) AS max_assentamento_gerado                                                                       
       , pessoal.assentamento                                                                                       
       , (   SELECT cod_assentamento                                                                                                          
                  , max(timestamp) as timestamp                                                                                               
               FROM pessoal.assentamento                                                                            
           GROUP BY cod_assentamento) AS max_assentamento                                                                                     
       , pessoal.assentamento_assentamento                                                                                       
       , pessoal.assentamento_evento                                                                   
       , folhapagamento.evento                                                                                      
   WHERE assentamento_gerado_contrato_servidor.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                          
     AND assentamento_gerado.cod_assentamento_gerado = max_assentamento_gerado.cod_assentamento_gerado                                        
     AND assentamento_gerado.timestamp = max_assentamento_gerado.timestamp                                                                    
     AND assentamento_gerado.cod_assentamento = assentamento.cod_assentamento                                                                 
     AND assentamento.cod_assentamento = max_assentamento.cod_assentamento                                                                    
     AND assentamento.timestamp = max_assentamento.timestamp                                                                                  
     AND assentamento.cod_assentamento = assentamento_assentamento.cod_assentamento                                                    
     AND assentamento.cod_assentamento = assentamento_evento.cod_assentamento                                                    
     AND assentamento.timestamp = assentamento_evento.timestamp                                                                  
     AND assentamento_evento.cod_evento= evento.cod_evento                                                                       
     AND NOT EXISTS (SELECT *                                                                                                                 
                       FROM pessoal.assentamento_gerado_excluido                                                    
                      WHERE assentamento_gerado_excluido.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                
                        AND assentamento_gerado_excluido.timestamp = assentamento_gerado.timestamp)
SQL;
        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $params
     * @param $filtro
     *
     * @return array
     */
    public function recuperaAssentamentoSEFIP($params, $filtro)
    {
        $sql =
            "SELECT assentamento_gerado_contrato_servidor.*                                                                                                  
     , periodo_inicial                                                                                                                          
     , periodo_final                                                                                                                            
     , assentamento_gerado.timestamp                                                                                                            
     , assentamento_gerado.cod_assentamento                                                                                                            
     , classificacao_assentamento.cod_tipo 
  FROM pessoal.assentamento_gerado_contrato_servidor                                                                                            
     , pessoal.assentamento_gerado                                                                                                              
     , (SELECT cod_assentamento_gerado                                                                                                          
             , max(timestamp) as timestamp                                                                                                      
          FROM pessoal.assentamento_gerado                                                                                                      
       GROUP BY cod_assentamento_gerado) as max_assentamento_gerado                                                                             
     , pessoal.assentamento                                                                                                                     
     , (SELECT cod_assentamento                                                                                                                 
             , max(timestamp) as timestamp                                                                                                      
          FROM pessoal.assentamento                                                                                                             
       GROUP BY cod_assentamento) as max_assentamento                                                                                           
     , pessoal.assentamento_assentamento                                                                                                        
     , pessoal.classificacao_assentamento                                                                                                       
 WHERE assentamento_gerado_contrato_servidor.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                              
   AND assentamento_gerado.cod_assentamento_gerado = max_assentamento_gerado.cod_assentamento_gerado                                            
   AND assentamento_gerado.timestamp = max_assentamento_gerado.timestamp                                                                        
   AND assentamento_gerado.cod_assentamento = assentamento.cod_assentamento                                                                     
   AND assentamento.cod_assentamento = max_assentamento.cod_assentamento                                                                        
   AND assentamento.timestamp = max_assentamento.timestamp                                                                                      
   AND assentamento.cod_assentamento = assentamento_assentamento.cod_assentamento                                                               
   AND assentamento_assentamento.cod_classificacao = classificacao_assentamento.cod_classificacao                                               
   AND NOT EXISTS (SELECT *                                                                                                                     
                     FROM pessoal.assentamento_gerado_excluido                                                                                  
                    WHERE assentamento_gerado_excluido.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                    
                      AND assentamento_gerado_excluido.timestamp = assentamento_gerado.timestamp)                                               
   AND NOT EXISTS (SELECT *                                                                                                                     
                     FROM pessoal.contrato_servidor_caso_causa                                                                                  
                    WHERE contrato_servidor_caso_causa.cod_contrato = assentamento_gerado_contrato_servidor.cod_contrato 
                      AND to_char(dt_rescisao,'yyyy-mm') != '" . $params["dtCompetencia1"] . "'  
                      AND to_char(dt_rescisao,'yyyy-mm') != '" . $params["dtCompetencia2"] . "')
";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $params
     * @param $filtro
     *
     * @return mixed
     */
    public function recuperaAssentamentoTemporario($params, $filtro)
    {
        $sql = "SELECT assentamento_gerado_contrato_servidor.*                                                                                                  
        , (SELECT trim(num_sefip) FROM pessoal.sefip WHERE cod_sefip = assentamento_mov_sefip_saida.cod_sefip_saida) as num_sefip                        
        , (SELECT repetir_mensal FROM pessoal.sefip WHERE cod_sefip = assentamento_mov_sefip_saida.cod_sefip_saida) as repetir_mensal              
        , periodo_inicial                                                                                                                          
        , periodo_final                                                                                                                            
        , assentamento_mov_sefip_saida.cod_sefip_saida                                                                          
        , assentamento_gerado.timestamp                                                                                                            
        , assentamento_gerado.cod_assentamento                                                                                                            
        , classificacao_assentamento.cod_tipo 
     FROM pessoal.assentamento_gerado_contrato_servidor                                                                                            
        , pessoal.assentamento_gerado                                                                                                              
        , (SELECT cod_assentamento_gerado                                                                                                          
                , max(timestamp) as timestamp                                                                                                      
             FROM pessoal.assentamento_gerado                                                                                                      
          GROUP BY cod_assentamento_gerado) as max_assentamento_gerado                                                                             
        , pessoal.assentamento                                                                                                                     
        , pessoal.assentamento_mov_sefip_saida                                                                                                     
        , (SELECT cod_assentamento                                                                                                                 
                , max(timestamp) as timestamp                                                                                                      
             FROM pessoal.assentamento                                                                                                             
          GROUP BY cod_assentamento) as max_assentamento                                                                                           
        , pessoal.assentamento_assentamento                                                                                                        
        , pessoal.classificacao_assentamento                                                                                                       
    WHERE assentamento_gerado_contrato_servidor.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                              
      AND assentamento_gerado.cod_assentamento_gerado = max_assentamento_gerado.cod_assentamento_gerado                                            
      AND assentamento_gerado.timestamp = max_assentamento_gerado.timestamp                                                                        
      AND assentamento_gerado.cod_assentamento = assentamento.cod_assentamento                                                                     
      AND assentamento.cod_assentamento = max_assentamento.cod_assentamento                                                                        
      AND assentamento.timestamp = max_assentamento.timestamp                                                                                      
      AND assentamento.cod_assentamento = assentamento_assentamento.cod_assentamento                                                               
      AND assentamento_assentamento.cod_classificacao = classificacao_assentamento.cod_classificacao                                               
      AND assentamento.cod_assentamento = assentamento_mov_sefip_saida.cod_assentamento                                                            
      AND assentamento.timestamp = assentamento_mov_sefip_saida.timestamp                                                                          
      AND NOT EXISTS (SELECT *                                                                                                                     
                        FROM pessoal.assentamento_gerado_excluido                                                                                  
                       WHERE assentamento_gerado_excluido.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                    
                         AND assentamento_gerado_excluido.timestamp = assentamento_gerado.timestamp)                                               
      AND NOT EXISTS (SELECT *                                                                                                                     
                        FROM pessoal.contrato_servidor_caso_causa                                                                                  
                       WHERE contrato_servidor_caso_causa.cod_contrato = assentamento_gerado_contrato_servidor.cod_contrato 
                          AND to_char(dt_rescisao,'yyyy-mm') != '" . $params["dtCompetencia1"] . "'  
                      AND to_char(dt_rescisao,'yyyy-mm') != '" . $params["dtCompetencia2"] . "')";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param null $filtro
     * @param null $ordem
     * @return object
     */
    public function recuperaAssentamentoGerado($filtro = null, $ordem = null)
    {
        $sql = "
            SELECT assentamento_gerado.*                                                                                                                
                FROM pessoal.assentamento_gerado_contrato_servidor                                                                
                    , pessoal.assentamento_gerado                                                                                  
                INNER JOIN pessoal.assentamento_assentamento                                                                       
                       ON assentamento_gerado.cod_assentamento = assentamento_assentamento.cod_assentamento                                                 
                INNER JOIN pessoal.classificacao_assentamento                                                                      
                        ON assentamento_assentamento.cod_classificacao = classificacao_assentamento.cod_classificacao                                       
                    , (   SELECT cod_assentamento_gerado                                                                                                    
                               , max(timestamp) as timestamp                                                                                                
                            FROM pessoal.assentamento_gerado                                                                       
                        GROUP BY cod_assentamento_gerado) AS max_assentamento_gerado                                                                        
                    , pessoal.assentamento                                                                                         
                    , (   SELECT cod_assentamento                                                                                                           
                               , max(timestamp) as timestamp                                                                                                
                            FROM pessoal.assentamento                                                                              
                        GROUP BY cod_assentamento) AS max_assentamento                                                                                      
                WHERE assentamento_gerado_contrato_servidor.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                           
                AND assentamento_gerado.cod_assentamento_gerado = max_assentamento_gerado.cod_assentamento_gerado                                         
                AND assentamento_gerado.timestamp = max_assentamento_gerado.timestamp                                                                     
                AND assentamento_gerado.cod_assentamento = assentamento.cod_assentamento                                                                  
                AND assentamento.cod_assentamento = max_assentamento.cod_assentamento                                                                     
                AND assentamento.timestamp = max_assentamento.timestamp                                                                                   
                AND NOT EXISTS (SELECT *                                                                                                                  
                                    FROM pessoal.assentamento_gerado_excluido                                                      
                                   WHERE assentamento_gerado_excluido.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                 
                                     AND assentamento_gerado_excluido.timestamp = assentamento_gerado.timestamp)";

        $sql .= $filtro ? $filtro : '';
        $sql .= $ordem ? " ORDER BY $ordem" : " ORDER BY cod_contrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param null $filtro
     * @return mixed
     */
    public function getAssentamentoGeradoByCodContratoAndExercicio($filtro = null)
    {
        $exercicio = null;
        $codContrato = 0;
        $tipo = null;
        if (!is_null($filtro)) {
            $exercicio = $filtro['exercicio'];
            $codContrato = $filtro['codContrato'];
            $tipo = $filtro['tipo'];
        }

        $sql = "select
                    cadastro.nom_cgm,
                    cadastro.registro,
                    (
                        select
                            descricao
                        from
                            pessoal.classificacao_assentamento
                        where
                            cod_classificacao = assentamento_assentamento.cod_classificacao
                    ) as classificacao,
                    assentamento_assentamento.descricao as assentamento,
                    case
                        when assentamento_gerado.periodo_inicial is null then to_char(
                            assentamento_gerado.periodo_final,
                            'dd/mm/yyyy'
                        )
                        when assentamento_gerado.periodo_final is null then to_char(
                            assentamento_gerado.periodo_inicial,
                            'dd/mm/yyyy'
                        )
                        else to_char(
                            assentamento_gerado.periodo_inicial,
                            'dd/mm/yyyy'
                        )|| ' a ' || to_char(
                            assentamento_gerado.periodo_final,
                            'dd/mm/yyyy'
                        )
                    end as periodo,
                    case
                        when(
                            assentamento_gerado.periodo_final - assentamento_gerado.periodo_inicial + 1
                        )> 9 then cast(
                            (
                                assentamento_gerado.periodo_final - assentamento_gerado.periodo_inicial + 1
                            ) as varchar
                        )
                        else '0' ||(
                            assentamento_gerado.periodo_final - assentamento_gerado.periodo_inicial + 1
                        )
                    end as dias,
                    (
                        select
                            num_norma || '/' || exercicio || ' - ' || descricao
                        from
                            normas.norma
                        where
                            cod_norma = assentamento_assentamento.cod_norma
                    ) as norma,
                    assentamento_gerado.observacao,
                    (
                        select
                            valor
                        from
                            administracao.configuracao
                        where
                            parametro = 'dtContagemInicial'
                            and exercicio = '".$exercicio."'
                    ) as contagem_tempo,
                    to_char(
                        cadastro.dt_posse,
                        'dd/mm/yyyy'
                    ) as dt_posse,
                    to_char(
                        cadastro.dt_nomeacao,
                        'dd/mm/yyyy'
                    ) as dt_nomeacao,
                    to_char(
                        cadastro.dt_admissao,
                        'dd/mm/yyyy'
                    ) as dt_admissao,
                    cadastro.desc_regime_funcao as regime,
                    cadastro.desc_sub_divisao_funcao as sub_divisao,
                    cadastro.desc_funcao as funcao,
                    cadastro.desc_especialidade_funcao as especialidade
                from
                    pessoal.assentamento_gerado,
                    (
                        select
                            cod_assentamento_gerado,
                            max( timestamp ) as timestamp
                        from
                            pessoal.assentamento_gerado
                        group by
                            cod_assentamento_gerado
                    ) as max_assentamento_gerado,
                    pessoal.assentamento_assentamento,
                    pessoal.assentamento_gerado_contrato_servidor,
                    (
                        select
                            *
                        from
                            recuperarContratoServidor(
                                'cgm,f,ef,rf,sf,o,oo,l,anp',
                                '',
                                0,
                                '".$tipo."',
                                '".$codContrato."',
                                '".$exercicio."'
                            )
                    ) as cadastro
                where
                    assentamento_gerado.cod_assentamento_gerado = max_assentamento_gerado.cod_assentamento_gerado
                    and assentamento_gerado.timestamp = max_assentamento_gerado.timestamp
                    and assentamento_gerado.cod_assentamento = assentamento_assentamento.cod_assentamento
                    and assentamento_gerado.cod_assentamento_gerado = assentamento_gerado_contrato_servidor.cod_assentamento_gerado
                    and assentamento_gerado_contrato_servidor.cod_contrato = cadastro.cod_contrato
                    and not exists(
                        select
                            1
                        from
                            pessoal.assentamento_gerado_excluido
                        where
                            assentamento_gerado.cod_assentamento_gerado = assentamento_gerado_excluido.cod_assentamento_gerado
                            and assentamento_gerado.timestamp = assentamento_gerado_excluido.timestamp
                    )
                order by
                    classificacao,
                    periodo_inicial,
                    nom_cgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
