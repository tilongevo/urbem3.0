CREATE OR REPLACE FUNCTION ldo.fn_receita_configuracao(integer, character)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $function$ 
DECLARE
    inCodPPA            ALIAS FOR $1;
    stExercicio         ALIAS FOR $2;
   
    stExercicioInicial   VARCHAR;
    stSql                VARCHAR;
    stSqlAux             VARCHAR;
    stUnidadeMedidaMetas VARCHAR;

    reRecord            RECORD;

    flValor_1           NUMERIC(14,2);
    flValor_2           NUMERIC(14,2);
    flValor_3           NUMERIC(14,2);
    flValor_4           NUMERIC(14,2);

    boOrcamento_1       NUMERIC(1);
    boOrcamento_2       NUMERIC(1);
    boOrcamento_3       NUMERIC(1);
    boOrcamento_4       NUMERIC(1);

BEGIN
    stExercicioInicial := TRIM(TO_CHAR((TO_NUMBER(stExercicio,'9999') - 4),'9999'));

    IF stExercicio::INTEGER < 2014 THEN
        stUnidadeMedidaMetas := 'unidade_medida_metas';
    ELSE
        stUnidadeMedidaMetas := 'unidade_medida_metas_receita';
    END IF;
    -----------------------------------------
    -- cria a tabela temporaria de retorno --
    -----------------------------------------
    CREATE TEMPORARY TABLE tmp_retorno (
        cod_tipo         INTEGER,
        exercicio        VARCHAR(4),
        cod_estrutural   VARCHAR,
        descricao        VARCHAR,
        tipo             CHAR(1),
        nivel            NUMERIC(1),
        rpps             NUMERIC(1),
        orcamento_1      NUMERIC(1),
        orcamento_2      NUMERIC(1),
        orcamento_3      NUMERIC(1),
        orcamento_4      NUMERIC(1),
        valor_1          NUMERIC(14,2),
        valor_2          NUMERIC(14,2),
        valor_3          NUMERIC(14,2),
        valor_4          NUMERIC(14,2)
    );
    
    
    ---------------------------------------------
    -- cria a tabela temporaria com os valores --
    ---------------------------------------------
    CREATE TEMPORARY TABLE tmp_valor AS
        SELECT conta_receita.cod_estrutural as cod_estrutural
             , CASE WHEN(receita.cod_recurso = 50)
                    THEN true
                    ELSE false
               END AS rpps
             , lote.dt_lote       as data
             , valor_lancamento.vl_lancamento   as valor
             , valor_lancamento.oid_lancamento             as primeira
             
          FROM contabilidade.valor_lancamento 
    INNER JOIN contabilidade.lancamento  
            ON valor_lancamento.exercicio    = lancamento.exercicio
           AND valor_lancamento.sequencia    = lancamento.sequencia
           AND valor_lancamento.cod_entidade = lancamento.cod_entidade
           AND valor_lancamento.cod_lote     = lancamento.cod_lote
           AND valor_lancamento.tipo         = lancamento.tipo
           AND valor_lancamento.tipo_valor   = 'D'
    INNER JOIN contabilidade.lote      
            ON lancamento.cod_lote     = lote.cod_lote
           AND lancamento.cod_entidade = lote.cod_entidade
           AND lancamento.exercicio    = lote.exercicio
           AND lancamento.tipo         = lote.tipo
    INNER JOIN contabilidade.lancamento_receita
            ON lancamento.cod_lote     = lancamento_receita.cod_lote
           AND lancamento.sequencia    = lancamento_receita.sequencia
           AND lancamento.exercicio    = lancamento_receita.exercicio
           AND lancamento.cod_entidade = lancamento_receita.cod_entidade
           AND lancamento.tipo         = lancamento_receita.tipo
           AND lancamento_receita.tipo = 'A'
    INNER JOIN orcamento.receita
            ON lancamento_receita.cod_receita = receita.cod_receita
           AND lancamento_receita.exercicio   = receita.exercicio
           AND lancamento_receita.estorno     = true
    INNER JOIN orcamento.conta_receita
            ON receita.cod_conta = conta_receita.cod_conta
           AND receita.exercicio = conta_receita.exercicio
    
         WHERE TO_CHAR(lote.dt_lote,'yyyy') BETWEEN stExercicioInicial AND stExercicio
         UNION ALL
         
        SELECT conta_receita.cod_estrutural as cod_estrutural
             , CASE WHEN(receita.cod_recurso = 50)
                    THEN true
                    ELSE false
               END AS rpps
             , lote.dt_lote       as data
             , valor_lancamento.vl_lancamento   as valor
             , valor_lancamento.oid_lancamento             as primeira
          FROM contabilidade.valor_lancamento
    INNER JOIN contabilidade.lancamento  
            ON valor_lancamento.exercicio    = lancamento.exercicio
           AND valor_lancamento.sequencia    = lancamento.sequencia
           AND valor_lancamento.cod_entidade = lancamento.cod_entidade
           AND valor_lancamento.cod_lote     = lancamento.cod_lote
           AND valor_lancamento.tipo         = lancamento.tipo
           AND valor_lancamento.tipo_valor   = 'C'
    INNER JOIN contabilidade.lote      
            ON lancamento.cod_lote     = lote.cod_lote
           AND lancamento.cod_entidade = lote.cod_entidade
           AND lancamento.exercicio    = lote.exercicio
           AND lancamento.tipo         = lote.tipo
    INNER JOIN contabilidade.lancamento_receita
            ON lancamento.cod_lote     = lancamento_receita.cod_lote
           AND lancamento.sequencia    = lancamento_receita.sequencia
           AND lancamento.exercicio    = lancamento_receita.exercicio
           AND lancamento.cod_entidade = lancamento_receita.cod_entidade
           AND lancamento.tipo         = lancamento_receita.tipo
           AND lancamento_receita.tipo = 'A'
    INNER JOIN orcamento.receita
            ON lancamento_receita.cod_receita = receita.cod_receita
           AND lancamento_receita.exercicio   = receita.exercicio
           AND lancamento_receita.estorno     = false
    INNER JOIN orcamento.conta_receita
            ON receita.cod_conta = conta_receita.cod_conta
           AND receita.exercicio = conta_receita.exercicio
         WHERE TO_CHAR(lote.dt_lote,'yyyy') BETWEEN stExercicioInicial AND stExercicio;
         
    ---------------------------------------------------
    -- verifica se existe movimentacao para cada ano --
    ---------------------------------------------------
    SELECT CASE WHEN EXISTS ( SELECT 1
                                FROM tmp_valor
                               WHERE TO_CHAR(data,'yyyy') = stExercicioInicial )
                THEN 1
                ELSE 0
           END
      INTO boOrcamento_1;

    SELECT CASE WHEN EXISTS ( SELECT 1
                                FROM tmp_valor
                               WHERE TO_CHAR(data,'yyyy') = TRIM(TO_CHAR((TO_NUMBER(stExercicioInicial,'9999') + 1),'9999')))
                THEN 1
                ELSE 0
           END
      INTO boOrcamento_2;

    SELECT CASE WHEN EXISTS ( SELECT 1
                                FROM tmp_valor
                               WHERE TO_CHAR(data,'yyyy') = TRIM(TO_CHAR((TO_NUMBER(stExercicioInicial,'9999') + 2),'9999')))
                THEN 1
                ELSE 0
           END
      INTO boOrcamento_3;

    SELECT CASE WHEN EXISTS ( SELECT 1
                                FROM tmp_valor
                               WHERE TO_CHAR(data,'yyyy') = TRIM(TO_CHAR((TO_NUMBER(stExercicioInicial,'9999') + 3),'9999')))
                THEN 1
                ELSE 0
           END
      INTO boOrcamento_4;
    -------------------------------------------------------
    -- recupera os tipos de receita que vao no relatorio --
    -------------------------------------------------------
    stSql := 'SELECT *
                   , publico.fn_mascarareduzida(cod_estrutural) AS estrutural_reduzido 
                FROM ldo.tipo_receita_despesa
               WHERE tipo = ''R'' 
                 AND nivel = 1
            ORDER BY cod_tipo ';

    FOR reRecord IN EXECUTE stSql
    LOOP
        SELECT SUM(valor)
          INTO flValor_1
          FROM tmp_valor
         WHERE CASE WHEN reRecord.cod_estrutural = '9.7.0.0.00.00.00.00.00'
                    THEN cod_estrutural LIKE '9.%'
                    WHEN reRecord.cod_estrutural = '1.3.9.0.00.00.00.00.00'
                    THEN (cod_estrutural LIKE '1.3.%' AND cod_estrutural NOT LIKE '1.3.2.%')
                    ELSE cod_estrutural LIKE '' || reRecord.estrutural_reduzido || '%'
               END
           AND TO_CHAR(data,'yyyy') = TRIM(TO_CHAR((TO_NUMBER(stExercicioInicial,'9999')),'9999'))
           AND CASE WHEN reRecord.cod_estrutural = '1.1.0.0.00.00.00.00.00'
                    THEN TRUE    
                    ELSE rpps = reRecord.rpps
               END;

        SELECT SUM(valor)
          INTO flValor_2
          FROM tmp_valor
         WHERE CASE WHEN reRecord.cod_estrutural = '9.7.0.0.00.00.00.00.00'
                    THEN cod_estrutural LIKE '9.%'
                    WHEN reRecord.cod_estrutural = '1.3.9.0.00.00.00.00.00'
                    THEN (cod_estrutural LIKE '1.3.%' AND cod_estrutural NOT LIKE '1.3.2.%')
                    ELSE cod_estrutural LIKE '' || reRecord.estrutural_reduzido || '%'
               END
           AND TO_CHAR(data,'yyyy') = TRIM(TO_CHAR((TO_NUMBER(stExercicioInicial,'9999') + 1),'9999'))
           AND CASE WHEN reRecord.cod_estrutural = '1.1.0.0.00.00.00.00.00'
                    THEN TRUE    
                    ELSE rpps = reRecord.rpps
               END;

        SELECT SUM(valor)
          INTO flValor_3
          FROM tmp_valor
         WHERE CASE WHEN reRecord.cod_estrutural = '9.7.0.0.00.00.00.00.00'
                    THEN cod_estrutural LIKE '9.%'
                    WHEN reRecord.cod_estrutural = '1.3.9.0.00.00.00.00.00'
                    THEN (cod_estrutural LIKE '1.3.%' AND cod_estrutural NOT LIKE '1.3.2.%')
                    ELSE cod_estrutural LIKE '' || reRecord.estrutural_reduzido || '%'
               END
           AND TO_CHAR(data,'yyyy') = TRIM(TO_CHAR((TO_NUMBER(stExercicioInicial,'9999') + 2),'9999'))
           AND CASE WHEN reRecord.cod_estrutural = '1.1.0.0.00.00.00.00.00'
                    THEN TRUE    
                    ELSE rpps = reRecord.rpps
               END;

        SELECT SUM(valor)
               - COALESCE(( SELECT SUM(vl_periodo)
                     FROM orcamento.conta_receita
               INNER JOIN orcamento.receita
                       ON conta_receita.exercicio = receita.exercicio
                      AND conta_receita.cod_conta = receita.cod_conta
               INNER JOIN orcamento.previsao_receita
                       ON receita.exercicio   = previsao_receita.exercicio
                      AND receita.cod_receita = previsao_receita.cod_receita
                    WHERE CASE WHEN reRecord.cod_estrutural = '9.7.0.0.00.00.00.00.00'
                               THEN cod_estrutural LIKE '9.%'
                               WHEN reRecord.cod_estrutural = '1.3.9.0.00.00.00.00.00'
                               THEN (cod_estrutural LIKE '1.3.%' AND cod_estrutural NOT LIKE '1.3.2.%')
                               ELSE cod_estrutural LIKE '' || reRecord.estrutural_reduzido || '%'
                          END
                      AND CASE WHEN reRecord.rpps
                               THEN receita.cod_recurso = 50       
                               ELSE receita.cod_recurso <> 50
                          END
                      AND conta_receita.exercicio = '2009'
                      AND (previsao_receita.periodo * TO_NUMBER((SELECT valor
                                                                   FROM administracao.configuracao
                                                                  WHERE cod_modulo = 8
                                                                    AND exercicio  = TRIM(TO_CHAR((TO_NUMBER(stExercicioInicial,'9999') + 3),'9999'))
                                                                    AND parametro  = stUnidadeMedidaMetas ),'9')) > TO_NUMBER(TO_CHAR(NOW(),'mm'),'99')
               ),0)
          INTO flValor_4
          FROM tmp_valor
         WHERE CASE WHEN reRecord.cod_estrutural = '9.7.0.0.00.00.00.00.00' 
                    THEN cod_estrutural LIKE '9.%'
                    WHEN reRecord.cod_estrutural = '1.3.9.0.00.00.00.00.00'
                    THEN (cod_estrutural LIKE '1.3.%' AND cod_estrutural NOT LIKE '1.3.2.%')
                    ELSE cod_estrutural LIKE '' || reRecord.estrutural_reduzido || '%'
               END     
           AND TO_CHAR(data,'yyyy') = TRIM(TO_CHAR((TO_NUMBER(stExercicioInicial,'9999') + 3),'9999'))
           AND CASE WHEN reRecord.cod_estrutural = '1.1.0.0.00.00.00.00.00'
                    THEN TRUE
                    ELSE rpps = reRecord.rpps
               END;

        IF flValor_1 IS NULL THEN 
            SELECT COALESCE(vl_arrecadado_liquidado,0) * -1
              INTO flValor_1
              FROM ldo.configuracao_receita_despesa  
             WHERE cod_tipo  = reRecord.cod_tipo
               AND tipo      = reRecord.tipo
               AND cod_ppa   = inCodPPA
               AND exercicio = stExercicioInicial;
        END IF;
    
  
        IF flValor_2 IS NULL THEN 
            SELECT COALESCE(vl_arrecadado_liquidado,0) * -1
              INTO flValor_2
              FROM ldo.configuracao_receita_despesa  
             WHERE cod_tipo  = reRecord.cod_tipo
               AND tipo      = reRecord.tipo
               AND cod_ppa   = inCodPPA
               AND exercicio = (TO_NUMBER(stExercicioInicial,'9999') + 1)::varchar;
        END IF;

        IF flValor_3 IS NULL THEN 
            SELECT COALESCE(vl_arrecadado_liquidado,0) * -1
              INTO flValor_3
              FROM ldo.configuracao_receita_despesa  
             WHERE cod_tipo  = reRecord.cod_tipo
               AND tipo      = reRecord.tipo
               AND cod_ppa   = inCodPPA
               AND exercicio = (TO_NUMBER(stExercicioInicial,'9999') + 2)::varchar ;
        END IF;

        IF flValor_4 IS NULL THEN 
            SELECT COALESCE(vl_arrecadado_liquidado,0) * -1
              INTO flValor_4
              FROM ldo.configuracao_receita_despesa  
             WHERE cod_tipo  = reRecord.cod_tipo
               AND tipo      = reRecord.tipo
               AND cod_ppa   = inCodPPA
               AND exercicio = (TO_NUMBER(stExercicioInicial,'9999') + 3)::varchar;
        END IF;

        -------------------------------------------------------------------------------------
        -- insere na tabela de retorno o somatorio do valor dos estruturais para os 4 anos --
        -------------------------------------------------------------------------------------
        INSERT INTO tmp_retorno VALUES( reRecord.cod_tipo
                                       ,stExercicio
                                       ,reRecord.cod_estrutural
                                       ,reRecord.descricao
                                       ,reRecord.tipo
                                       ,reRecord.nivel
                                       ,CASE WHEN (reRecord.rpps IS TRUE)
                                             THEN 1
                                             ELSE 0
                                        END
                                       ,boOrcamento_1
                                       ,boOrcamento_2
                                       ,boOrcamento_3
                                       ,boOrcamento_4
                                       ,flValor_1 * -1
                                       ,flValor_2 * -1 
                                       ,flValor_3 * -1
                                       ,flValor_4 * -1);


    END LOOP;

    ----------------------------------------------------------
    -- insere na tabela de retorno o somatorio dos niveis 0 --
    ----------------------------------------------------------
    stSql := ' SELECT publico.fn_mascarareduzida(cod_estrutural) AS estrutural_reduzido
                    , *
                 FROM ldo.tipo_receita_despesa
                WHERE nivel = 0
                  AND tipo = ''R''
             ORDER BY cod_tipo'; 
    
    FOR reRecord IN EXECUTE stSql
    LOOP
        SELECT SUM(COALESCE(valor_1,0)) 
          INTO flValor_1
          FROM tmp_retorno
         WHERE cod_estrutural LIKE reRecord.estrutural_reduzido || '%' 
           AND nivel = 1;

         SELECT SUM(COALESCE(valor_2,0)) 
          INTO flValor_2
          FROM tmp_retorno
         WHERE cod_estrutural LIKE reRecord.estrutural_reduzido || '%' 
           AND nivel = 1;  

        SELECT SUM(COALESCE(valor_3,0)) 
          INTO flValor_3
          FROM tmp_retorno
         WHERE cod_estrutural LIKE reRecord.estrutural_reduzido || '%' 
           AND nivel = 1;

        SELECT SUM(COALESCE(valor_4,0)) 
          INTO flValor_4
          FROM tmp_retorno
         WHERE cod_estrutural LIKE reRecord.estrutural_reduzido || '%' 
           AND nivel = 1;

        INSERT INTO tmp_retorno ( SELECT reRecord.cod_tipo
                                       , stExercicio
                                       , reRecord.cod_estrutural
                                       , reRecord.descricao
                                       , reRecord.tipo
                                       , reRecord.nivel
                                       , CASE WHEN (reRecord.rpps IS TRUE)
                                             THEN 1
                                             ELSE 0
                                         END
                                       , boOrcamento_1
                                       , boOrcamento_2
                                       , boOrcamento_3
                                       , boOrcamento_4
                                       , flValor_1
                                       , flValor_2
                                       , flValor_3
                                       , flValor_4);
    END LOOP;
 
    stSql := ' SELECT * 
                 FROM tmp_retorno
             ORDER BY cod_tipo';

    FOR reRecord IN EXECUTE stSql
    LOOP
        RETURN NEXT reRecord;
    END LOOP;
        
    DROP TABLE tmp_valor;
    DROP TABLE tmp_retorno;

END;

$function$
