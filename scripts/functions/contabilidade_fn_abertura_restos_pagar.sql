CREATE OR REPLACE FUNCTION contabilidade.fn_abertura_restos_pagar(character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE
    stExercicio             ALIAS FOR $1;

    stSql                   VARCHAR   := '';
    stCodEntidade           VARCHAR   := '';
    entidadeAtual           VARCHAR   := '';
    entidadeAnterior        VARCHAR   := '';
    inCodLote               INTEGER   := NULL;
    stExercicioAnterior    VARCHAR   := '';
    sequencia               VARCHAR   := '';
    flSomatorio             NUMERIC   := 0;
    reRegistro              RECORD;

BEGIN
    stExercicioAnterior := trim(to_char((to_number(stExercicio,'9999')-1),'9999'));
    -------------------------------------
    -- Retorna as entidades do sistema --
    -------------------------------------
    SELECT ARRAY_TO_STRING(ARRAY(SELECT CAST(entidade.cod_entidade AS VARCHAR)
                                   FROM orcamento.entidade
                                  WHERE entidade.exercicio = stExercicio
                                    AND EXISTS ( SELECT 1
                                                   FROM contabilidade.lancamento
                                                  WHERE entidade.exercicio    = lancamento.exercicio
                                                    AND entidade.cod_entidade = lancamento.cod_entidade
                                               )
                           ),',')
      INTO stCodEntidade;

    ---------------------------------------------------------------------
    -- Cria tabela restos processados e não processados exercicios anteriores
    ---------------------------------------------------------------------
CREATE TEMPORARY TABLE tmp_valores AS
        SELECT stExercicio AS exercicio
             , *
          FROM (
                    SELECT cod_estutural_debito.cod_estrutural               AS cod_estrutural_debito
                         , cod_estutural_credito.cod_estrutural              AS cod_estrutural_credito
                         , lpad(tb.cod_recurso::varchar,4,'0')               AS cod_recurso
                         , tipo
                         , cod_entidade
                         , COALESCE(contabilidade.saldo_conta_banco_recurso(stExercicio,tb.cod_recurso,cod_entidade),0) AS saldo
                         , SUM(total_processados_exercicio_anterior)         AS total_processados_exercicio_anterior
                         , SUM(total_nao_processados_exercicio_anterior)     AS total_nao_processados_exercicio_anterior
                         , SUM(total_processados_exercicios_anteriores)      AS restos_processados_exercicios_anteriores
                         , SUM(total_nao_processados_exercicios_anteriores)  AS restos_nao_processados_exercicios_anteriores
                         , SUM(liquidados_nao_pagos)                         AS liquidado_a_pagar
                         , SUM(empenhados_nao_liquidados)                    AS a_liquidar

                      FROM contabilidade.fn_abertura_restos_pagar_recurso(stExercicio, stCodEntidade,'01/01/' || stExercicio) AS tb
                           (  cod_recurso                                 integer
                            , tipo                                        varchar
                            , cod_entidade                                integer
                            , total_processados_exercicios_anteriores     numeric
                            , total_processados_exercicio_anterior        numeric
                            , total_nao_processados_exercicios_anteriores numeric
                            , total_nao_processados_exercicio_anterior    numeric
                            , liquidados_nao_pagos                        numeric
                            , empenhados_nao_liquidados                   numeric
                           )
                 LEFT JOIN (    SELECT plano_conta.cod_conta
                                     , plano_recurso.cod_recurso
                                     , cod_estrutural
                                     , nom_recurso
                                  FROM contabilidade.plano_analitica
                            INNER JOIN contabilidade.plano_recurso
                                    ON plano_recurso.cod_plano= plano_analitica.cod_plano
                                   AND plano_recurso.exercicio= plano_analitica.exercicio
                            INNER JOIN orcamento.recurso
                                    ON recurso.cod_recurso =plano_recurso.cod_recurso
                                   AND recurso.exercicio = plano_recurso.exercicio
                            INNER JOIN contabilidade.plano_conta
                                    ON plano_conta.cod_conta = plano_analitica.cod_conta
                                   AND plano_conta.exercicio = plano_analitica.exercicio
                                 WHERE plano_conta.exercicio= stExercicio
                                   AND cod_estrutural like '8.2.1.1.1%'
                                   AND cod_estrutural = ( SELECT MIN(cod_estrutural) AS cod_estrutural
                                                            FROM contabilidade.plano_analitica
                                                      INNER JOIN contabilidade.plano_recurso AS PR
                                                              ON PR.cod_plano= plano_analitica.cod_plano
                                                             AND PR.exercicio= plano_analitica.exercicio
                                                      INNER JOIN orcamento.recurso
                                                              ON recurso.cod_recurso = PR.cod_recurso
                                                             AND recurso.exercicio = PR.exercicio
                                                      INNER JOIN contabilidade.plano_conta AS pc
                                                              ON pc.cod_conta = plano_analitica.cod_conta
                                                             AND pc.exercicio = plano_analitica.exercicio
                                                           WHERE pc.exercicio= plano_conta.exercicio
                                                             AND PR.cod_recurso = plano_recurso.cod_recurso
                                                             AND cod_estrutural like '8.2.1.1.1%'
                                                        GROUP BY PR.cod_recurso )
                           ) AS cod_estutural_debito
                        ON cod_estutural_debito.cod_recurso = tb.cod_recurso
                       AND cod_estutural_debito.nom_recurso = tb.tipo

                 LEFT JOIN (    SELECT plano_conta.cod_conta
                                     , plano_recurso.cod_recurso
                                     , cod_estrutural
                                     , nom_recurso
                                  FROM contabilidade.plano_analitica
                            INNER JOIN contabilidade.plano_recurso
                                    ON plano_recurso.cod_plano= plano_analitica.cod_plano
                                   AND plano_recurso.exercicio= plano_analitica.exercicio
                            INNER JOIN orcamento.recurso
                                    ON recurso.cod_recurso =plano_recurso.cod_recurso
                                   AND recurso.exercicio = plano_recurso.exercicio
                            INNER JOIN contabilidade.plano_conta
                                    ON plano_conta.cod_conta = plano_analitica.cod_conta
                                   AND plano_conta.exercicio = plano_analitica.exercicio
                                 WHERE plano_conta.exercicio= stExercicio
                                   AND cod_estrutural like '8.2.1.1.2%'
                                   AND cod_estrutural = ( SELECT MIN(cod_estrutural) AS cod_estrutural
                                                            FROM contabilidade.plano_analitica
                                                      INNER JOIN contabilidade.plano_recurso AS PR
                                                              ON PR.cod_plano= plano_analitica.cod_plano
                                                             AND PR.exercicio= plano_analitica.exercicio
                                                      INNER JOIN orcamento.recurso
                                                              ON recurso.cod_recurso = PR.cod_recurso
                                                             AND recurso.exercicio = PR.exercicio
                                                      INNER JOIN contabilidade.plano_conta AS pc
                                                              ON pc.cod_conta = plano_analitica.cod_conta
                                                             AND pc.exercicio = plano_analitica.exercicio
                                                           WHERE pc.exercicio= plano_conta.exercicio
                                                             AND PR.cod_recurso = plano_recurso.cod_recurso
                                                             AND cod_estrutural like '8.2.1.1.2%'
                                                        GROUP BY PR.cod_recurso )
                           ) AS cod_estutural_credito
                        ON cod_estutural_credito.cod_recurso = tb.cod_recurso
                       AND cod_estutural_credito.nom_recurso = tb.tipo

                  GROUP BY cod_estutural_debito.cod_estrutural
                         , cod_estutural_credito.cod_estrutural
                         , tb.cod_recurso
                         , tb.tipo
                         , tb.cod_entidade

                  ORDER BY cod_recurso
                         , tipo
               ) AS tabela

         WHERE (   saldo > 0
                OR restos_processados_exercicios_anteriores > 0
                OR restos_nao_processados_exercicios_anteriores > 0
                OR liquidado_a_pagar > 0
                OR a_liquidar > 0
               ) ;


    ---------------------------------------------------------------------
    -- Faz lancamento dos restos  processados exercicio anterior
    ---------------------------------------------------------------------
    stSql := '
             SELECT entidade.exercicio
                        , entidade.cod_entidade
                        , buscaCodigoEstrutural(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                               WHERE cod_estrutural like ''5.3.2.7%''
                                                                                                   AND plano_conta.exercicio= entidade.exercicio
                                                                                              )::VARCHAR) as cod_estrutural_credito

                        , buscaCodigoEstrutural(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                              WHERE cod_estrutural like ''5.3.2.1%''
                                                                                                   AND plano_conta.exercicio= entidade.exercicio)::VARCHAR) as cod_estrutural_debito

                        , contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                                                         FROM contabilidade.plano_conta
                                                                                                                                 INNER JOIN contabilidade.plano_analitica
                                                                                                                                             ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                                                           AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                                                                       WHERE cod_estrutural like ''5.3.2.7%''
                                                                                                                                           AND plano_conta.exercicio= entidade.exercicio), entidade.cod_entidade) AS valor
                        , CAST(''Processados no Exercicio Imediatamente Anterior.''  AS VARCHAR) AS complemento
                FROM orcamento.entidade
              WHERE entidade.exercicio = ''' || stExercicio || '''
                  AND entidade.cod_entidade IN  ('|| stCodEntidade ||')
                  AND contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(entidade.exercicio,(SELECT plano_analitica.cod_plano
                        FROM contabilidade.plano_conta
                        INNER JOIN contabilidade.plano_analitica
                            ON plano_analitica.exercicio = plano_conta.exercicio
                            AND plano_analitica.cod_conta= plano_conta.cod_conta
                        WHERE cod_estrutural like ''5.3.2.7%''
                        AND plano_conta.exercicio= entidade.exercicio), entidade.cod_entidade)!=0

         UNION ALL

              SELECT entidade.exercicio
                        , entidade.cod_entidade
                        , buscaCodigoEstrutural(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                               WHERE cod_estrutural like ''6.3.2.1%''
                                                                                                   AND plano_conta.exercicio= entidade.exercicio
                                                                                              )::VARCHAR) as cod_estrutural_credito

                        , buscaCodigoEstrutural(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                              WHERE cod_estrutural like ''6.3.2.7%''
                                                                                                   AND plano_conta.exercicio= entidade.exercicio)::VARCHAR) as cod_estrutural_debito

                        , contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                                                         FROM contabilidade.plano_conta
                                                                                                                                 INNER JOIN contabilidade.plano_analitica
                                                                                                                                             ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                                                           AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                                                                       WHERE cod_estrutural like ''6.3.2.7%''
                                                                                                                                           AND plano_conta.exercicio= entidade.exercicio), entidade.cod_entidade) AS valor
                        , CAST(''Processados no Exercicio Imediatamente Anterior.'' AS VARCHAR) AS complemento
                FROM orcamento.entidade
              WHERE entidade.exercicio = ''' || stExercicio || '''
                  AND entidade.cod_entidade IN  ('|| stCodEntidade ||')
                  AND contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(entidade.exercicio,(SELECT plano_analitica.cod_plano
                        FROM contabilidade.plano_conta
                        INNER JOIN contabilidade.plano_analitica
                            ON plano_analitica.exercicio = plano_conta.exercicio
                            AND plano_analitica.cod_conta= plano_conta.cod_conta
                        WHERE cod_estrutural like ''6.3.2.7%''
                        AND plano_conta.exercicio= entidade.exercicio), entidade.cod_entidade)!=0


       UNION ALL
    ---------------------------------------------------------------------
    -- Faz lancamento dos restos  não processados exercicio anteiros
    ---------------------------------------------------------------------
         SELECT entidade.exercicio
                        , entidade.cod_entidade
                        , buscaCodigoEstrutural(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                               WHERE cod_estrutural like ''5.3.1.7%''
                                                                                                   AND plano_conta.exercicio= entidade.exercicio
                                                                                              )::VARCHAR) as cod_estrutural_credito

                        , buscaCodigoEstrutural(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                              WHERE cod_estrutural like ''5.3.1.1%''
                                                                                                   AND plano_conta.exercicio= entidade.exercicio)::VARCHAR) as cod_estrutural_debito

                        , contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                                                         FROM contabilidade.plano_conta
                                                                                                                                 INNER JOIN contabilidade.plano_analitica
                                                                                                                                             ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                                                           AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                                                                       WHERE cod_estrutural like ''5.3.1.7%''
                                                                                                                                           AND plano_conta.exercicio= entidade.exercicio), entidade.cod_entidade) AS valor
                        , CAST(''Não Processados no Exercicio Imediatamente Anterior.'' AS VARCHAR) AS complemento
                FROM orcamento.entidade
              WHERE entidade.exercicio = ''' || stExercicio || '''
                  AND entidade.cod_entidade IN  ('|| stCodEntidade ||')
                  AND contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(entidade.exercicio,(SELECT plano_analitica.cod_plano
                        FROM contabilidade.plano_conta
                        INNER JOIN contabilidade.plano_analitica
                            ON plano_analitica.exercicio = plano_conta.exercicio
                            AND plano_analitica.cod_conta= plano_conta.cod_conta
                        WHERE cod_estrutural like ''5.3.1.7%''
                        AND plano_conta.exercicio= entidade.exercicio), entidade.cod_entidade)!=0

    UNION ALL
                SELECT entidade.exercicio
                        , entidade.cod_entidade
                        , buscaCodigoEstrutural(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                               WHERE cod_estrutural like ''6.3.1.1%''
                                                                                                   AND plano_conta.exercicio= entidade.exercicio
                                                                                              )::VARCHAR) as cod_estrutural_credito

                        , buscaCodigoEstrutural(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                              WHERE cod_estrutural like ''6.3.1.7.1%''
                                                                                                   AND plano_conta.exercicio= entidade.exercicio)::VARCHAR) as cod_estrutural_debito

                        , contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(entidade.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                                                         FROM contabilidade.plano_conta
                                                                                                                                 INNER JOIN contabilidade.plano_analitica
                                                                                                                                             ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                                                           AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                                                                       WHERE cod_estrutural like ''6.3.1.7.1%''
                                                                                                                                           AND plano_conta.exercicio= entidade.exercicio), entidade.cod_entidade) AS valor
                        , CAST(''Não Processados no Exercicio Imediatamente Anterior.'' AS VARCHAR) AS complemento
                FROM orcamento.entidade
              WHERE entidade.exercicio = ''' || stExercicio || '''
                  AND entidade.cod_entidade IN  ('|| stCodEntidade ||')
                  AND contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(entidade.exercicio,(SELECT plano_analitica.cod_plano
                        FROM contabilidade.plano_conta
                        INNER JOIN contabilidade.plano_analitica
                            ON plano_analitica.exercicio = plano_conta.exercicio
                            AND plano_analitica.cod_conta= plano_conta.cod_conta
                        WHERE cod_estrutural like ''6.3.1.7.1%''
                        AND plano_conta.exercicio= entidade.exercicio), entidade.cod_entidade)!=0
UNION ALL
 ------------------------------------------------------------------------------------------------------------
    -- Faz lancamento dos restos  não processados exercicio anteiros
 ------------------------------------------------------------------------------------------------------------
';
IF stExercicio < '2015' THEN
stSql := stSql || '
               SELECT tmp_valores.exercicio
                    , tmp_valores.cod_entidade
                    , tmp_valores.cod_estrutural_credito
                    , tmp_valores.cod_estrutural_debito
                    , tmp_valores.restos_nao_processados_exercicios_anteriores
                    , CAST(''Não Processados nos Exercicios Anteriores.'' AS VARCHAR) AS complemento
                FROM tmp_valores
              WHERE tmp_valores.cod_entidade IN  ('|| stCodEntidade ||')

UNION ALL
';
END IF;

IF stExercicio < '2016' THEN
    stSql := stSql || '
        SELECT tmp_valores.exercicio
                    , tmp_valores.cod_entidade
                   , buscaCodigoEstrutural(tmp_valores.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                               WHERE cod_estrutural like ''6.3.1.1%''
                                                                                                   AND plano_conta.exercicio= tmp_valores.exercicio
                                                                                              )::VARCHAR) as cod_estrutural_credito

                     , buscaCodigoEstrutural(tmp_valores.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                 FROM contabilidade.plano_conta
                                                                                         INNER JOIN contabilidade.plano_analitica
                                                                                                     ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                   AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                              WHERE cod_estrutural like ''5.3.1.2%''
                                                                                                   AND plano_conta.exercicio= tmp_valores.exercicio )::VARCHAR) as cod_estrutural_debito
                    , SUM(tmp_valores.restos_nao_processados_exercicios_anteriores) AS valor
                    , CAST(''Não Processados nos Exercicios Anteriores.'' AS VARCHAR) AS complemento
             FROM tmp_valores
           WHERE tmp_valores.cod_entidade IN  ('|| stCodEntidade ||')
      GROUP BY  tmp_valores.exercicio,  tmp_valores.cod_entidade , cod_estrutural_credito, cod_estrutural_debito
    ';
END IF;

IF stExercicio < '2015' THEN

stSql := stSql || '

UNION ALL
          SELECT conta_contabil_rp_np.exercicio
                     , conta_contabil_rp_np.cod_entidade
                     , buscaCodigoEstrutural(conta_contabil_rp_np.exercicio,(SELECT plano_analitica.cod_plano
                                                                                               FROM contabilidade.plano_conta
                                                                                               INNER JOIN contabilidade.plano_analitica
                                                                                                           ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                         AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                                     WHERE cod_estrutural like ''2.3.7.2.5.03.00%''
                                                                                                         AND plano_conta.exercicio= conta_contabil_rp_np.exercicio
                                                                                                    )::VARCHAR) as cod_estrutural_credito

                     , buscaCodigoEstrutural(conta_contabil_rp_np.exercicio,(SELECT plano_analitica.cod_plano
                                                                                               FROM contabilidade.plano_analitica
                                                                                             WHERE plano_analitica.cod_conta = conta_contabil_rp_np.cod_conta
                                                                                                  AND plano_analitica.natureza_saldo = pa.natureza_saldo
                                                                                                   AND plano_analitica.exercicio= conta_contabil_rp_np.exercicio)::VARCHAR) as cod_estrutural_debito

                     , contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(conta_contabil_rp_np.exercicio,(SELECT plano_analitica.cod_plano
                                                                                                                                       FROM contabilidade.plano_analitica
                                                                                                                                     WHERE plano_analitica.cod_conta = conta_contabil_rp_np.cod_conta
                                                                                                                                         AND plano_analitica.natureza_saldo = pa.natureza_saldo
                                                                                                                                         AND plano_analitica.exercicio= conta_contabil_rp_np.exercicio), conta_contabil_rp_np.cod_entidade) AS valor
                     , CAST(''Não Processados nos Exercicios Anteriores.'' AS VARCHAR) AS complemento
             FROM contabilidade.conta_contabil_rp_np
       INNER JOIN contabilidade.plano_analitica AS pa
               ON pa.cod_conta = conta_contabil_rp_np.cod_conta
              ANd pa.exercicio = conta_contabil_rp_np.exercicio
          WHERE conta_contabil_rp_np.exercicio  = ''' || stExercicio || '''
               AND conta_contabil_rp_np.cod_entidade IN  ('|| stCodEntidade ||')
UNION ALL
 ------------------------------------------------------------------------------------------------------------
    -- Faz lancamento dos restos  processados exercicio anteiros
 ------------------------------------------------------------------------------------------------------------
         SELECT tmp_valores.exercicio
                    , tmp_valores.cod_entidade
                    , tmp_valores.cod_estrutural_credito
                    , tmp_valores.cod_estrutural_debito
                    , tmp_valores.restos_processados_exercicios_anteriores AS valor
                    , CAST(''Processados nos Exercicios Anteriores.'' AS VARCHAR) AS complemento
                FROM tmp_valores
              WHERE tmp_valores.cod_entidade IN  ('|| stCodEntidade ||')
';
ELSE
    IF stExercicio < '2016' THEN
        stSql := stSql || '
         UNION ALL
        ';
    END IF;

    stSql := stSql || '
     ------------------------------------------------------------------------------------------------------------
        -- Faz lancamento dos restos  processados exercicio anteiros
     ------------------------------------------------------------------------------------------------------------
             SELECT tmp_valores.exercicio
                  , tmp_valores.cod_entidade
                  , tmp_valores.cod_estrutural_credito
                  , tmp_valores.cod_estrutural_debito
                  , (tmp_valores.restos_processados_exercicios_anteriores + tmp_valores.total_processados_exercicio_anterior) AS valor
                  , CAST(''Processados nos Exercicios Anteriores.'' AS VARCHAR) AS complemento
               FROM tmp_valores
              WHERE tmp_valores.cod_entidade IN  ('|| stCodEntidade ||')
    ';
    IF stExercicio > '2016' THEN
        stSql := stSql || '
            AND ( tmp_valores.restos_processados_exercicios_anteriores > 0 OR tmp_valores.total_processados_exercicio_anterior > 0)
        ';
    END IF;
END IF;

IF stExercicio < '2016' THEN
    stSql := stSql || '

    UNION ALL

            SELECT tmp_valores.exercicio
                        , tmp_valores.cod_entidade
                       , buscaCodigoEstrutural(tmp_valores.exercicio ,(SELECT plano_analitica.cod_plano
                                                                                                     FROM contabilidade.plano_conta
                                                                                             INNER JOIN contabilidade.plano_analitica
                                                                                                         ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                       AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                                   WHERE cod_estrutural like ''6.3.2.1%''
                                                                                                       AND plano_conta.exercicio= tmp_valores.exercicio
                                                                                                  )::VARCHAR) as cod_estrutural_credito

                         , buscaCodigoEstrutural(tmp_valores.exercicio ,(SELECT plano_analitica.cod_plano
                                                                                                     FROM contabilidade.plano_conta
                                                                                             INNER JOIN contabilidade.plano_analitica
                                                                                                         ON plano_analitica.exercicio = plano_conta.exercicio
                                                                                                       AND plano_analitica.cod_conta= plano_conta.cod_conta
                                                                                                  WHERE cod_estrutural like ''5.3.2.2%''
                                                                                                       AND plano_conta.exercicio= tmp_valores.exercicio )::VARCHAR) as cod_estrutural_debito
                        , SUM(tmp_valores.restos_processados_exercicios_anteriores) AS valor
                        , CAST(''Processados nos Exercicios Anteriores.'' AS VARCHAR) AS complemento
                 FROM tmp_valores
               WHERE tmp_valores.cod_entidade IN  ('|| stCodEntidade ||')
          GROUP BY  tmp_valores.exercicio,  tmp_valores.cod_entidade , cod_estrutural_credito, cod_estrutural_debito

        ';
END IF;

    FOR reRegistro IN EXECUTE stSql
    LOOP
        entidadeAtual := reRegistro.cod_entidade;
        IF(entidadeAtual != entidadeAnterior)
        THEN
            inCodLote := contabilidade.fn_insere_lote( reRegistro.exercicio                    -- stExercicio
                                                     , reRegistro.cod_entidade                 -- inCodEntidade
                                                     , 'M'                                     -- stTipo
                                                     , 'Abertura do Exercicio Restos a Pagar'  -- stNomeLote
                                                     , '02/01/' || stExercicio                 -- stDataLote
                                                     );
        END IF;

        IF(reRegistro.valor <> 0)
        THEN
            sequencia := FazerLancamento(reRegistro.cod_estrutural_debito,reRegistro.cod_estrutural_credito,824,reRegistro.exercicio,abs(reRegistro.valor),reRegistro.complemento,inCodLote,CAST('M' AS VARCHAR),reRegistro.cod_entidade);
        END IF;

    END LOOP;

    RETURN stCodEntidade;

    DROP TABLE tmp_valores;

END;
$function$
