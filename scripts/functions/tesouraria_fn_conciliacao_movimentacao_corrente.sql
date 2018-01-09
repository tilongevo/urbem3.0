CREATE OR REPLACE FUNCTION tesouraria.fn_conciliacao_movimentacao_corrente(character varying, character varying, character varying, character varying, character varying, character varying, integer, character varying)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $_$
DECLARE

    stExercicio         ALIAS FOR $1;
    stCodEntidade       ALIAS FOR $2;
    stDtInicial         ALIAS FOR $3;
    stDtFinal           ALIAS FOR $4;
    stFiltro            ALIAS FOR $5;
    stFiltroArrecadacao ALIAS FOR $6;
    inCodPlano          ALIAS FOR $7;
    stMes               ALIAS FOR $8;

    stSql               VARCHAR := '';
    reRegistro          RECORD;
    boRetorno           BOOLEAN;

BEGIN

    SELECT tesouraria.fn_listar_arrecadacao_conciliacao( stFiltroArrecadacao
                                                       , stFiltroArrecadacao
                                                       , stDtFinal
                                                       , stDtInicial
                                                       , inCodPlano
                                                       , stCodEntidade
                                                       , stExercicio) INTO boRetorno;

    stSql := '
    SELECT
        CAST(substr(dt_lancamento::text,1,4)||substr(dt_lancamento::text,6,2)||substr(dt_lancamento::text,9,2)
        ||tipo
        ||CASE WHEN tipo = ''A'' THEN cod_receita
               WHEN tipo = ''P'' THEN cod_lote
               WHEN tipo = ''T'' THEN cod_lote
               WHEN tipo = ''M'' THEN sequencia
        END AS varchar) AS ordem,
        CAST(TO_CHAR(dt_lancamento,''dd/mm/yyyy'') as varchar) as dt_lancamento,
        CAST(CASE WHEN conciliar = ''true''
                  THEN TO_CHAR(dt_conciliacao,''dd/mm/yyyy'')
                  ELSE ''''::VARCHAR
             END AS VARCHAR) AS dt_conciliacao,
        CASE
            WHEN observacao <> '''' THEN CAST(descricao||'' - ''||observacao AS varchar)
            ELSE CAST(descricao AS varchar)
        END,
        CAST(CASE
           WHEN (tipo = ''P'') THEN vl_lancamento * -1
           WHEN (tipo = ''B'') THEN vl_lancamento * -1
           WHEN (tipo = ''T'' AND tipo_valor = ''C'') THEN vl_lancamento * -1
           WHEN (tipo = ''T'' AND tipo_valor = ''D'') THEN vl_lancamento
           WHEN (tipo = ''A'' and tipo_valor = ''C'' ) THEN vl_lancamento *-1
           WHEN (tipo = ''A'' and tipo_valor = ''D'' ) THEN vl_lancamento
           WHEN (tipo = ''M'') THEN vl_lancamento
        END AS decimal) AS vl_lancamento,
        CAST(vl_lancamento as decimal) as vl_original,
        CAST(tipo_valor AS varchar) as tipo_valor,
        CAST(conciliar AS varchar) as conciliar,
        CAST(cod_lote AS integer) as cod_lote,
        CAST(tipo AS varchar) as tipo,
        CAST(sequencia AS integer) as sequencia,
        CAST(cod_entidade AS integer) as cod_entidade,
        CAST(tipo_movimentacao AS varchar) as tipo_movimentacao,
        CAST(cod_plano as integer) as cod_plano,
        CAST(cod_arrecadacao as integer) as cod_arrecadacao,
        CAST(cod_receita as integer) as cod_receita,
        CAST(cod_bordero as integer) as cod_bordero,
        CAST(timestamp_arrecadacao as varchar) as timestamp_arrecadacao,
        CAST(timestamp_estornada as varchar) as timestamp_estornada,
        CAST(tipo_arrecadacao as varchar) as tipo_arrecadacao,
        CAST(mes as varchar) as mes,
        CAST(tipo||CASE WHEN tipo_valor = ''C'' THEN ''E'' ELSE '''' END
            ||CASE WHEN tipo = ''A'' THEN cod_arrecadacao
                   WHEN tipo = ''P'' THEN cod_lote
                   WHEN tipo = ''T'' THEN cod_lote
                   WHEN tipo = ''M'' THEN sequencia
        END as varchar) as id,
        CAST(exercicio_conciliacao AS varchar) AS exercicio_conciliacao
     FROM (

    -- PAGAMENTOS
    -------------
     SELECT
            cp.cod_lote,
            BOLETIM.dt_boletim as dt_lancamento,
            TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao,
            boletim.exercicio,
            p.cod_plano,
            cast(
            CASE WHEN TRIM(substring(ENLP.observacao,1,60)) = '''' THEN
                CASE WHEN (ENL.exercicio_empenho < P.exercicio_boletim) THEN
                     ''Pagamento de RP n° '' || ENL.cod_empenho || ''/'' || ENL.exercicio_empenho
                ELSE ''Pagamento de Empenho n° '' || ENL.cod_empenho || ''/'' || ENL.exercicio_empenho
                END
            ELSE
                CASE WHEN (ENL.exercicio_empenho < P.exercicio_boletim) THEN
                     ''Pagamento de RP n° ''|| ENL.cod_empenho || ''/'' || ENL.exercicio_empenho
                ELSE ''Pagamento de Empenho n° '' || ENL.cod_empenho || ''/'' || ENL.exercicio_empenho
                END
            END  as varchar)
            || CASE WHEN (cheque_emissao_ordem_pagamento.num_cheque IS NOT NULL)
                    THEN '' CH '' || cheque_emissao_ordem_pagamento.num_cheque
                    ELSE '' ''
               END
            as descricao,
            replace(trim(substring(coalesce(ENLP.observacao,''''),1,60)),'''','''') as observacao,
            cast(enlp.vl_pago as numeric ) as vl_lancamento,
            cast( ''D'' as varchar ) as tipo_valor,
            cp.tipo,
            cp.sequencia,
            boletim.cod_entidade,
            CASE
                 WHEN lc.cod_plano is not null
                     THEN ''true''
                     ELSE ''''
            END as conciliar,
            ''A'' as tipo_movimentacao,
            0 as cod_arrecadacao,
            0 as cod_receita,
            ttp.cod_bordero,
            CAST('''' as text) as timestamp_arrecadacao,
            CAST('''' as text) as timestamp_estornada,
            CAST('''' as text) as tipo_arrecadacao
            ,coalesce( lpad(lc.mes::text,2,''0''), '''') as mes
            ,lc.exercicio_conciliacao
        FROM

            tesouraria.boletim as BOLETIM,
            tesouraria.pagamento as P,
            contabilidade.pagamento as cp



            LEFT JOIN tesouraria.conciliacao_lancamento_contabil as lc
            on(    cp.cod_lote         = lc.cod_lote
               AND cp.tipo             = lc.tipo
               AND cp.sequencia        = lc.sequencia
               AND cp.exercicio        = lc.exercicio
               AND cp.cod_entidade     = lc.cod_entidade
               AND lc.tipo_valor = ''D''
            )
            LEFT JOIN tesouraria.conciliacao
                   ON lc.cod_plano             = conciliacao.cod_plano
                  AND lc.exercicio_conciliacao = conciliacao.exercicio
                  AND lc.mes                   = conciliacao.mes

            JOIN contabilidade.lancamento_empenho as LE
            ON (   le.cod_entidade = cp.cod_entidade
               AND le.tipo         = cp.tipo
               AND le.sequencia    = cp.sequencia
               AND le.exercicio    = cp.exercicio
               AND le.cod_lote     = cp.cod_lote
               AND le.estorno = ''false''
            )
            JOIN contabilidade.lote as lo
            ON (   le.cod_lote     = lo.cod_lote
               AND le.cod_entidade = lo.cod_entidade
               AND le.tipo         = lo.tipo
               AND le.exercicio    = lo.exercicio
            ),
            empenho.pagamento_liquidacao as EPL
  LEFT JOIN tesouraria.cheque_emissao_ordem_pagamento
         ON cheque_emissao_ordem_pagamento.cod_ordem    = EPL.cod_ordem
        AND cheque_emissao_ordem_pagamento.exercicio    = EPL.exercicio
        AND cheque_emissao_ordem_pagamento.cod_entidade = EPL.cod_entidade
        AND cheque_emissao_ordem_pagamento.timestamp_emissao = ( SELECT MAX(timestamp_emissao)
                                                                   FROM tesouraria.cheque_emissao_ordem_pagamento
                                                                  WHERE cod_ordem    = EPL.cod_ordem
                                                                    AND exercicio    = EPL.exercicio
                                                                    AND cod_entidade = EPL.cod_entidade ),
            empenho.pagamento_liquidacao_nota_liquidacao_paga as EPLNLP
            LEFT JOIN tesouraria.transacoes_pagamento as TTP
            ON (    ttp.cod_ordem    = EPLNLP.cod_ordem
                AND ttp.cod_entidade = EPLNLP.cod_entidade
                AND ttp.exercicio    = EPLNLP.exercicio
            ),
            empenho.nota_liquidacao_paga                      as ENLP,
            empenho.nota_liquidacao                           as ENL
        WHERE
                BOLETIM.cod_boletim         = P.cod_boletim
            AND BOLETIM.exercicio           = P.exercicio_boletim
            AND BOLETIM.cod_entidade        = P.cod_entidade

            AND P.cod_nota                  = ENLP.cod_nota
            AND P.exercicio                 = ENLP.exercicio
            AND P.cod_entidade              = ENLP.cod_entidade
            AND P.timestamp                 = ENLP.timestamp

            AND ENLP.cod_nota               = ENL.cod_nota
            AND ENLP.exercicio              = ENL.exercicio
            AND ENLP.cod_entidade           = ENL.cod_entidade

            AND EPL.cod_ordem               = EPLNLP.cod_ordem
            AND EPL.exercicio               = EPLNLP.exercicio
            AND EPL.cod_entidade            = EPLNLP.cod_entidade
            AND EPL.exercicio_liquidacao    = EPLNLP.exercicio_liquidacao
            AND EPL.cod_nota                = EPLNLP.cod_nota

            AND EPLNLP.exercicio_liquidacao = ENLP.exercicio
            AND EPLNLP.cod_nota             = ENLP.cod_nota
            AND EPLNLP.cod_entidade         = ENLP.cod_entidade
            AND EPLNLP.timestamp            = ENLP.timestamp

            AND ENLP.exercicio              = CP.exercicio_liquidacao
            AND ENLP.cod_nota               = CP.cod_nota
            AND ENLP.cod_entidade           = CP.cod_entidade
            AND ENLP.timestamp              = CP.timestamp

            AND p.cod_plano = '||inCodPlano||'
            AND p.cod_entidade in ( '||stCodEntidade||' )
            AND TO_CHAR(BOLETIM.dt_boletim,''mm'') = TO_CHAR(TO_DATE( '''||stDtFinal||'''::VARCHAR, ''dd/mm/yyyy'' ),''mm'')
            AND to_char(P.timestamp,''yyyy'')::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
            AND lo.dt_lote = to_date(to_char(P.timestamp,''yyyy-mm-dd''),''yyyy-mm-dd'')

     UNION
                SELECT
                       conciliacao_pagamento.cod_lote
                     , boletim.dt_boletim as dt_lancamento
                     , TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao
                     , boletim.exercicio
                     , pagamento.cod_plano
                     , CAST(
                        CASE WHEN TRIM(substring(nota_liquidacao_paga_anulada.observacao,1,60)) =  '''' THEN
                            CASE WHEN (nota_liquidacao.exercicio_empenho < pagamento.exercicio_boletim) THEN
                                 ''Estorno de Pagamento de RP n° '' || nota_liquidacao.cod_empenho || ''/'' || nota_liquidacao.exercicio_empenho
                            ELSE ''Estorno de Pagamento de Empenho n° '' || nota_liquidacao.cod_empenho || ''/'' || nota_liquidacao.exercicio_empenho
                            END
                        ELSE
                            CASE WHEN (nota_liquidacao.exercicio_empenho < pagamento.exercicio_boletim) THEN
                                 ''Estorno de Pagamento de RP n° '' || nota_liquidacao.cod_empenho || ''/'' || nota_liquidacao.exercicio_empenho
                            ELSE ''Estorno de Pagamento de Empenho n° '' || nota_liquidacao.cod_empenho || ''/'' || nota_liquidacao.exercicio_empenho
                            END
                        END  as varchar)
                        || CASE WHEN (cheque_emissao_ordem_pagamento.num_cheque IS NOT NULL) THEN
                                '' CH '' || cheque_emissao_ordem_pagamento.num_cheque
                           END
                        AS descricao
                      , replace(trim(substring(coalesce(nota_liquidacao_paga_anulada.observacao,''''),1,60)),'''','''') AS observacao
                      , nota_liquidacao_paga_anulada.vl_anulado AS vl_lancamento
                      , cast( ''C'' as varchar ) AS tipo_valor
                      , conciliacao_pagamento.tipo
                      , conciliacao_pagamento.sequencia
                      , boletim.cod_entidade
                      , CASE
                            WHEN conciliacao_lancamento_contabil.cod_plano is not null
                                THEN ''true''
                                ELSE ''''
                       END as conciliar
                     , ''A'' as tipo_movimentacao
                     , 0 AS cod_arrecadacao
                     , 0 AS cod_receita
                     , transacoes_pagamento.cod_bordero
                     , CAST('''' as text ) AS timestamp_arrecadacao
                     , CAST('''' as text ) AS timestamp_estornada
                     , CAST('''' as text ) AS tipo_arrecadacao
                     , coalesce( lpad(conciliacao_lancamento_contabil.mes::text,2,''0''), '''') AS mes
                     , conciliacao_lancamento_contabil.exercicio_conciliacao

                FROM tesouraria.boletim

	      INNER JOIN tesouraria.pagamento_estornado
     		      ON boletim.cod_boletim  = pagamento_estornado.cod_boletim
		         AND boletim.exercicio    = pagamento_estornado.exercicio_boletim
		         AND boletim.cod_entidade = pagamento_estornado.cod_entidade

	      INNER JOIN tesouraria.pagamento
		          ON pagamento_estornado.cod_nota     = pagamento.cod_nota
		         AND pagamento_estornado.exercicio    = pagamento.exercicio
                 AND pagamento_estornado.cod_entidade = pagamento.cod_entidade
		         AND pagamento_estornado.timestamp    = pagamento.timestamp

		    , contabilidade.pagamento AS conciliacao_pagamento

           INNER JOIN contabilidade.pagamento_estorno
                   ON conciliacao_pagamento.cod_lote             = pagamento_estorno.cod_lote
                  AND conciliacao_pagamento.tipo                 = pagamento_estorno.tipo
                  AND conciliacao_pagamento.sequencia            = pagamento_estorno.sequencia
                  AND conciliacao_pagamento.exercicio            = pagamento_estorno.exercicio
                  AND conciliacao_pagamento.cod_entidade         = pagamento_estorno.cod_entidade
                  AND conciliacao_pagamento.timestamp            = pagamento_estorno.timestamp
                  AND conciliacao_pagamento.cod_nota             = pagamento_estorno.cod_nota
                  AND conciliacao_pagamento.exercicio_liquidacao = pagamento_estorno.exercicio_liquidacao

           LEFT JOIN tesouraria.conciliacao_lancamento_contabil
                  ON conciliacao_pagamento.cod_lote         = conciliacao_lancamento_contabil.cod_lote
                 AND conciliacao_pagamento.tipo             = conciliacao_lancamento_contabil.tipo
                 AND conciliacao_pagamento.sequencia        = conciliacao_lancamento_contabil.sequencia
                 AND conciliacao_pagamento.exercicio        = conciliacao_lancamento_contabil.exercicio
                 AND conciliacao_pagamento.cod_entidade     = conciliacao_lancamento_contabil.cod_entidade
                 AND conciliacao_lancamento_contabil.tipo_valor = ''C''

           LEFT JOIN tesouraria.conciliacao
                  ON conciliacao_lancamento_contabil.cod_plano             = conciliacao.cod_plano
                 AND conciliacao_lancamento_contabil.exercicio_conciliacao = conciliacao.exercicio
                 AND conciliacao_lancamento_contabil.mes                   = conciliacao.mes

          INNER JOIN contabilidade.lancamento_empenho
                  ON lancamento_empenho.cod_entidade = conciliacao_pagamento.cod_entidade
                 AND lancamento_empenho.tipo         = conciliacao_pagamento.tipo
                 AND lancamento_empenho.sequencia    = conciliacao_pagamento.sequencia
                 AND lancamento_empenho.exercicio    = conciliacao_pagamento.exercicio
                 AND lancamento_empenho.cod_lote     = conciliacao_pagamento.cod_lote
                 AND lancamento_empenho.estorno = ''true''

         INNER JOIN contabilidade.lote
                 ON lancamento_empenho.cod_lote     = lote.cod_lote
                AND lancamento_empenho.cod_entidade = lote.cod_entidade
                AND lancamento_empenho.tipo         = lote.tipo
                AND lancamento_empenho.exercicio    = lote.exercicio

            , empenho.pagamento_liquidacao

        LEFT JOIN ( SELECT MAX(timestamp_emissao), num_cheque, cod_ordem, exercicio, cod_entidade
                      FROM tesouraria.cheque_emissao_ordem_pagamento
                  GROUP BY num_cheque, cod_ordem, exercicio, cod_entidade
        ) AS cheque_emissao_ordem_pagamento
          ON cheque_emissao_ordem_pagamento.cod_ordem    = pagamento_liquidacao.cod_ordem
         AND cheque_emissao_ordem_pagamento.exercicio    = pagamento_liquidacao.exercicio
         AND cheque_emissao_ordem_pagamento.cod_entidade = pagamento_liquidacao.cod_entidade

            , empenho.pagamento_liquidacao_nota_liquidacao_paga

         LEFT JOIN tesouraria.transacoes_pagamento
                ON transacoes_pagamento.cod_ordem    = pagamento_liquidacao_nota_liquidacao_paga.cod_ordem
               AND transacoes_pagamento.cod_entidade = pagamento_liquidacao_nota_liquidacao_paga.cod_entidade
               AND transacoes_pagamento.exercicio    = pagamento_liquidacao_nota_liquidacao_paga.exercicio

            , empenho.nota_liquidacao_paga
            , empenho.nota_liquidacao_paga_anulada
            , empenho.nota_liquidacao

        WHERE
                pagamento_estornado.cod_nota          = nota_liquidacao_paga_anulada.cod_nota
            AND pagamento_estornado.exercicio         = nota_liquidacao_paga_anulada.exercicio
            AND pagamento_estornado.cod_entidade      = nota_liquidacao_paga_anulada.cod_entidade
            AND pagamento_estornado.timestamp_anulado = nota_liquidacao_paga_anulada.timestamp_anulada
            AND pagamento_estornado.timestamp         = nota_liquidacao_paga_anulada.timestamp

            AND nota_liquidacao_paga_anulada.exercicio         = pagamento_estorno.exercicio_liquidacao
            AND nota_liquidacao_paga_anulada.cod_nota          = pagamento_estorno.cod_nota
            AND nota_liquidacao_paga_anulada.cod_entidade      = pagamento_estorno.cod_entidade
            AND nota_liquidacao_paga_anulada.timestamp         = pagamento_estorno.timestamp
            AND nota_liquidacao_paga_anulada.timestamp_anulada = pagamento_estorno.timestamp_anulada

            AND nota_liquidacao_paga_anulada.cod_nota     = nota_liquidacao_paga.cod_nota
            AND nota_liquidacao_paga_anulada.exercicio    = nota_liquidacao_paga.exercicio
            AND nota_liquidacao_paga_anulada.cod_entidade = nota_liquidacao_paga.cod_entidade
            AND nota_liquidacao_paga_anulada.timestamp    = nota_liquidacao_paga.timestamp

            AND nota_liquidacao_paga.cod_nota     = nota_liquidacao.cod_nota
            AND nota_liquidacao_paga.exercicio    = nota_liquidacao.exercicio
            AND nota_liquidacao_paga.cod_entidade = nota_liquidacao.cod_entidade

            AND pagamento_liquidacao.cod_ordem            = pagamento_liquidacao_nota_liquidacao_paga.cod_ordem
            AND pagamento_liquidacao.exercicio            = pagamento_liquidacao_nota_liquidacao_paga.exercicio
            AND pagamento_liquidacao.cod_entidade         = pagamento_liquidacao_nota_liquidacao_paga.cod_entidade
            AND pagamento_liquidacao.exercicio_liquidacao = pagamento_liquidacao_nota_liquidacao_paga.exercicio_liquidacao
            AND pagamento_liquidacao.cod_nota             = pagamento_liquidacao_nota_liquidacao_paga.cod_nota

            AND pagamento_liquidacao_nota_liquidacao_paga.exercicio_liquidacao = nota_liquidacao_paga.exercicio
            AND pagamento_liquidacao_nota_liquidacao_paga.cod_nota             = nota_liquidacao_paga.cod_nota
            AND pagamento_liquidacao_nota_liquidacao_paga.cod_entidade         = nota_liquidacao_paga.cod_entidade
            AND pagamento_liquidacao_nota_liquidacao_paga.timestamp            = nota_liquidacao_paga.timestamp

            AND pagamento.cod_plano = '||inCodPlano||'
            AND pagamento_estornado.cod_entidade in ( '||stCodEntidade||' )
            AND to_char(pagamento_estornado.timestamp_anulado,''yyyy'')::INTEGER BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
            AND TO_CHAR(BOLETIM.dt_boletim,''mm'') =  TO_CHAR(TO_DATE( '''||stDtFinal||'''::VARCHAR, ''dd/mm/yyyy'' ),''mm'')
            AND lote.dt_lote = to_date(to_char(pagamento_estornado.timestamp_anulado,''yyyy-mm-dd''),''yyyy-mm-dd'')



     UNION

    -- TRANSFERENCIAS
    ------------------
    -- BUSCA AS ARRECADAÇÕES EXTRA, PAGAMENTOS EXTRA, DEPÓSITOS/RETIRADAS, APLICAÇÃO E  RESGATES ( DEBITO )
        SELECT
             t.cod_lote
            ,BOLETIM.dt_boletim as dt_lancamento
            ,TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao
            ,t.exercicio
            ,t.cod_plano_debito as cod_plano
            ,trim(TTT.descricao || '' - CD:''||T.cod_plano_debito ||'' | CC:'' || T.cod_plano_credito) as descricao
            ,replace(trim(substring(coalesce(T.observacao,''''),1,60)),'''','''') as observacao
            ,t.valor as vl_lancamento
            ,cast( ''D'' as varchar ) as tipo_valor
            ,cast( ''T'' as varchar ) as tipo
            ,coalesce (lc.sequencia,1) as sequencia
            ,boletim.cod_entidade
            ,CASE
                WHEN lc.cod_plano is not null
                    THEN ''true''
                    ELSE ''''
            END as conciliar
            ,''A'' as tipo_movimentacao
            ,0 as cod_arrecadacao
            ,0 as cod_receita
            ,tttt.cod_bordero
            ,CAST('''' as text) as timestamp_arrecadacao
            ,CAST('''' as text) as timestamp_estornada
            ,CAST('''' as text) as tipo_arrecadacao
            ,coalesce( lpad(lc.mes::text,2,''0''), '''') as mes
            ,lc.exercicio_conciliacao
        FROM
            tesouraria.boletim              as BOLETIM
            ,tesouraria.transferencia        as T
            LEFT JOIN tesouraria.transacoes_transferencia as tttt
            ON (    tttt.cod_entidade = t.cod_entidade
                AND tttt.numcgm = t.cgm_usuario
                AND tttt.exercicio = t.exercicio
                AND tttt.cod_plano = t.cod_plano_debito
            )
            LEFT JOIN tesouraria.conciliacao_lancamento_contabil as lc
            on(    t.cod_lote         = lc.cod_lote
               AND t.tipo             = lc.tipo
               AND t.exercicio        = lc.exercicio
               AND t.cod_entidade     = lc.cod_entidade
               AND t.cod_plano_debito = lc.cod_plano
               AND lc.tipo_valor = ''D''
               AND lc.sequencia = 1
            )
            LEFT JOIN tesouraria.conciliacao
                   ON lc.cod_plano             = conciliacao.cod_plano
                  AND lc.exercicio_conciliacao = conciliacao.exercicio
                  AND lc.mes                   = conciliacao.mes

            ,tesouraria.tipo_transferencia   as TTT

        WHERE
                TTT.cod_tipo          = T.cod_tipo

            AND BOLETIM.cod_boletim   = T.cod_boletim
            AND BOLETIM.exercicio     = T.exercicio
            AND BOLETIM.cod_entidade  = T.cod_entidade

            AND T.cod_plano_debito    = '||inCodPlano||'
            AND T.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
            AND T.cod_entidade        in ( '||stCodEntidade||' )
            AND TO_CHAR(BOLETIM.dt_boletim,''mm'') = TO_CHAR(TO_DATE( '''||stDtFinal||''', ''dd/mm/yyyy'' ),''mm'')

     UNION

    -- BUSCA AS ARRECADAÇÕES EXTRA, PAGAMENTOS EXTRA, DEPÓSITOS/RETIRADAS, APLICAÇÃO E  RESGATES ( CREDITO )

        SELECT
             t.cod_lote
            ,BOLETIM.dt_boletim as dt_lancamento
            ,TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao
            ,t.exercicio
            ,t.cod_plano_credito as cod_plano
            ,trim(TTT.descricao || '' - CD:''||T.cod_plano_debito ||'' | CC:'' || T.cod_plano_credito) as descricao
            ,replace(trim(substring(coalesce(T.observacao,''''),1,60)),'''','''') as observacao
            ,T.valor as vl_lancamento
            ,cast( ''C'' as varchar ) as tipo_valor
            ,cast( ''T'' as varchar ) as tipo
            ,coalesce(lc.sequencia,1) as sequencia
            ,boletim.cod_entidade
            ,CASE
                WHEN lc.cod_plano is not null
                    THEN ''true''
                    ELSE ''''
            END as conciliar
            ,''A'' as tipo_movimentacao
            ,0 as cod_arrecadacao
            ,0 as cod_receita
            ,tttt.cod_bordero
            ,CAST('''' as text) as timestamp_arrecadacao
            ,CAST('''' as text) as timestamp_estornada
            ,CAST('''' as text) as tipo_arrecadacao
            ,coalesce( lpad(lc.mes::text,2,''0''), '''') as mes
            ,lc.exercicio_conciliacao
        FROM
            tesouraria.boletim              as BOLETIM
            ,tesouraria.transferencia        as T
            LEFT JOIN tesouraria.transacoes_transferencia as tttt
            ON (    tttt.cod_entidade = t.cod_entidade
                AND tttt.numcgm = t.cgm_usuario
                AND tttt.exercicio = t.exercicio
                AND tttt.cod_plano = t.cod_plano_credito
            )
            LEFT JOIN tesouraria.conciliacao_lancamento_contabil as lc
            on(    t.cod_lote          = lc.cod_lote
               AND t.tipo              = lc.tipo
               AND t.exercicio         = lc.exercicio
               AND t.cod_entidade      = lc.cod_entidade
               AND t.cod_plano_credito = lc.cod_plano
               AND lc.tipo_valor = ''C''
               AND lc.sequencia = 1
            )
            LEFT JOIN tesouraria.conciliacao
                   ON lc.cod_plano             = conciliacao.cod_plano
                  AND lc.exercicio_conciliacao = conciliacao.exercicio
                  AND lc.mes                   = conciliacao.mes

            ,tesouraria.tipo_transferencia   as TTT

        WHERE
                TTT.cod_tipo          = T.cod_tipo

            AND BOLETIM.cod_boletim   = T.cod_boletim
            AND BOLETIM.exercicio     = T.exercicio
            AND BOLETIM.cod_entidade  = T.cod_entidade

            AND T.cod_plano_credito    = '||inCodPlano||'
            AND T.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
            AND T.cod_entidade        in ( '||stCodEntidade||' )
            AND TO_CHAR(BOLETIM.dt_boletim,''mm'') = TO_CHAR(TO_DATE( '''||stDtFinal||''', ''dd/mm/yyyy'' ),''mm'')

     UNION

     -- ESTORNO DE TRANSFERENCIAS
      SELECT
             te.cod_lote_estorno
            ,BOLETIM.dt_boletim as dt_lancamento
            ,TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao
            ,te.exercicio
            ,t.cod_plano_debito as cod_plano
            ,trim('' Estorno de '' || TTT.descricao || '' - CD: ''||T.cod_plano_credito ||'' | CC: '' || T.cod_plano_debito ) as descricao
            ,replace(trim(substring(coalesce(T.observacao,''''),1,60)),'''','''') as observacao
            ,TE.valor as vl_lancamento
            ,cast( ''D'' as varchar ) as tipo_valor
            ,cast( ''T'' as varchar ) as tipo
            ,coalesce(lc.sequencia,1) as sequencia
            ,boletim.cod_entidade
            ,CASE
                WHEN lc.cod_plano is not null
                    THEN ''true''
                    ELSE ''''
            END as conciliar
            ,''A'' as tipo_movimentacao
            ,0 as cod_arrecadacao
            ,0 as cod_receita
            ,tttt.cod_bordero
            ,CAST('''' as text) as timestamp_arrecadacao
            ,CAST('''' as text) as timestamp_estornada
            ,CAST('''' as text) as tipo_arrecadacao
            ,coalesce( lpad(lc.mes::text,2,''0''), '''') as mes
            ,lc.exercicio_conciliacao
       FROM
            tesouraria.boletim                  as BOLETIM,
            tesouraria.transferencia            as T
            LEFT JOIN tesouraria.transacoes_transferencia as tttt
            ON (    tttt.cod_entidade = t.cod_entidade
                AND tttt.numcgm = t.cgm_usuario
                AND tttt.exercicio = t.exercicio
                AND tttt.cod_plano = t.cod_plano_debito
            )
            JOIN tesouraria.transferencia_estornada  as TE
            ON (    TE.exercicio          = T.exercicio
                AND TE.cod_entidade       = T.cod_entidade
                AND TE.cod_lote           = T.cod_lote
                AND TE.tipo               = T.tipo
            )
            LEFT JOIN tesouraria.conciliacao_lancamento_contabil as lc
            on(    te.cod_lote_estorno = lc.cod_lote
               AND te.tipo             = lc.tipo
               AND te.exercicio        = lc.exercicio
               AND te.cod_entidade     = lc.cod_entidade
               AND t.cod_plano_debito  = lc.cod_plano
               AND lc.tipo_valor = ''D''
               AND lc.sequencia = 1
            )
            LEFT JOIN tesouraria.conciliacao
                   ON lc.cod_plano             = conciliacao.cod_plano
                  AND lc.exercicio_conciliacao = conciliacao.exercicio
                  AND lc.mes                   = conciliacao.mes

           ,tesouraria.tipo_transferencia       as TTT
       WHERE
           TE.exercicio          = T.exercicio     AND
           TE.cod_entidade       = T.cod_entidade  AND
           TE.cod_lote           = T.cod_lote      AND
           TE.tipo               = T.tipo          AND
           TTT.cod_tipo          = T.cod_tipo        AND

           BOLETIM.cod_boletim   = TE.cod_boletim     AND
           BOLETIM.exercicio     = TE.exercicio       AND
           BOLETIM.cod_entidade  = TE.cod_entidade

            AND T.cod_plano_debito    = '||inCodPlano||'
            AND TE.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
            AND TE.cod_entidade        in ( '||stCodEntidade||' )
            AND TO_CHAR(BOLETIM.dt_boletim,''mm'') = TO_CHAR(TO_DATE( '''||stDtFinal||''', ''dd/mm/yyyy''),''mm'')

    UNION

      SELECT
             te.cod_lote_estorno
            ,BOLETIM.dt_boletim as dt_lancamento
            ,TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao
            ,te.exercicio
            ,t.cod_plano_credito as cod_plano
            ,trim('' Estorno de '' || TTT.descricao || '' - CD: ''||T.cod_plano_credito ||'' | CC: '' || T.cod_plano_debito ) as descricao
            ,replace(trim(substring(coalesce(T.observacao,''''),1,60)),'''','''') as observacao
            ,TE.valor as vl_lancamento
            ,cast( ''C'' as varchar ) as tipo_valor
            ,cast( ''T'' as varchar ) as tipo
            ,coalesce(lc.sequencia,1) as sequencia
            ,boletim.cod_entidade
            ,CASE
                WHEN lc.cod_plano is not null
                    THEN ''true''
                    ELSE ''''
            END as conciliar
            ,''A'' as tipo_movimentacao
            ,0 as cod_arrecadacao
            ,0 as cod_receita
            ,tttt.cod_bordero
            ,CAST('''' as text) as timestamp_arrecadacao
            ,CAST('''' as text) as timestamp_estornada
            ,CAST('''' as text) as tipo_arrecadacao
            ,coalesce( lpad(lc.mes::text,2,''0''), '''') as mes
            ,lc.exercicio_conciliacao
       FROM
            tesouraria.boletim                  as BOLETIM,
            tesouraria.transferencia            as T
            LEFT JOIN tesouraria.transacoes_transferencia as tttt
            ON (    tttt.cod_entidade = t.cod_entidade
                AND tttt.numcgm = t.cgm_usuario
                AND tttt.exercicio = t.exercicio
                AND tttt.cod_plano = t.cod_plano_credito
            )
            JOIN tesouraria.transferencia_estornada  as TE
            ON (    TE.exercicio          = T.exercicio
                AND TE.cod_entidade       = T.cod_entidade
                AND TE.cod_lote           = T.cod_lote
                AND TE.tipo               = T.tipo
            )
            LEFT JOIN tesouraria.conciliacao_lancamento_contabil as lc
            on(    te.cod_lote_estorno = lc.cod_lote
               AND te.tipo             = lc.tipo
               AND te.exercicio        = lc.exercicio
               AND te.cod_entidade     = lc.cod_entidade
               AND t.cod_plano_credito  = lc.cod_plano
               AND lc.tipo_valor = ''C''
               AND lc.sequencia = 1
                )
            LEFT JOIN tesouraria.conciliacao
                   ON lc.cod_plano             = conciliacao.cod_plano
                  AND lc.exercicio_conciliacao = conciliacao.exercicio
                  AND lc.mes                   = conciliacao.mes
           ,tesouraria.tipo_transferencia       as TTT
       WHERE
           TE.exercicio          = T.exercicio     AND
           TE.cod_entidade       = T.cod_entidade  AND
           TE.cod_lote           = T.cod_lote      AND
           TE.tipo               = T.tipo          AND
           TTT.cod_tipo          = T.cod_tipo        AND

           BOLETIM.cod_boletim   = TE.cod_boletim     AND
           BOLETIM.exercicio     = TE.exercicio       AND
           BOLETIM.cod_entidade  = TE.cod_entidade

            AND T.cod_plano_credito    = '||inCodPlano||'
            AND TE.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
            AND TE.cod_entidade        in ( '||stCodEntidade||' )
            AND TO_CHAR(BOLETIM.dt_boletim,''mm'') = TO_CHAR(TO_DATE( '''||stDtFinal||''', ''dd/mm/yyyy''),''mm'')

    UNION
    -- ARRECADACOES
    -- ARRECADACAO DE RECEITA
     SELECT
        0 as cod_lote,
        TO_DATE(TA.dt_boletim,''dd/mm/yyyy'') as dt_lancamento,
        TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao,
        TA.exercicio,
        TA.conta_debito,
        CAST( ''Arrecadação da receita Boletim nr. ''||TA.cod_boletim as varchar ) as descricao,
        '''' as observacao,
        TA.valor,
        ''D'' as tipo_valor,
        ''A'' as tipo,
        0 as sequencia,
        TA.cod_entidade,
        CASE WHEN TCLA.cod_plano IS NOT NULL
          THEN ''true''
          ELSE ''''
        END AS conciliar,
        ''A'' as tipo_movimentacao,
        TA.cod_arrecadacao,
        TA.cod_receita,
        0 as cod_bordero,
        CAST(TA.timestamp_arrecadacao as text) as timestamp_arrecadacao,
        CAST('''' as text) as timestamp_estornada,
        TA.tipo_arrecadacao
        ,coalesce( lpad(tcla.mes::text,2,''0''), '''') as mes
        ,tcla.exercicio_conciliacao
     FROM
        tmp_arrecadacao as TA
        LEFT JOIN tesouraria.conciliacao_lancamento_arrecadacao AS TCLA
        ON( TA.exercicio             = TCLA.exercicio
        AND TA.cod_arrecadacao       = TCLA.cod_arrecadacao
        AND TA.timestamp_arrecadacao = TCLA.timestamp_arrecadacao
        )
            LEFT JOIN tesouraria.conciliacao
                   ON tcla.cod_plano             = conciliacao.cod_plano
                  AND tcla.exercicio_conciliacao = conciliacao.exercicio
                  AND tcla.mes                   = conciliacao.mes
    WHERE ta.tipo_arrecadacao = ''A''
        AND EXISTS (
           SELECT true
             FROM tesouraria.arrecadacao as tta
            WHERE ta.exercicio               = TTA.exercicio
              AND ta.cod_arrecadacao         = TTA.cod_arrecadacao
              AND ta.timestamp_arrecadacao   = TTA.timestamp_arrecadacao
        )

    UNION

    -- ESTORNO DE DEDUCAO
     SELECT
        0 as cod_lote,
        TO_DATE(TA.dt_boletim::VARCHAR,''dd/mm/yyyy'') as dt_lancamento,
        TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao,
        TA.exercicio,
        TA.conta_debito,
        CAST( ''Estorno de Dedução de receita Boletim nr. ''||TA.cod_boletim as varchar) as descricao,
        '''' as observacao,
        TA.valor,
        ''D'' as tipo_valor,
        ''A'' as tipo,
        0 as sequencia,
        TA.cod_entidade,
        CASE WHEN TCLAE.cod_plano IS NOT NULL
          THEN ''true''
          ELSE ''''
        END AS conciliar,
        ''A'' as tipo_movimentacao,
        TA.cod_arrecadacao,
        TA.cod_receita,
        0 as cod_bordero,
        CAST(TA.timestamp_arrecadacao as text) as timestamp_arrecadacao,
        CAST(ta.timestamp_estornada as text) as timestamp_estornada,
        TA.tipo_arrecadacao
        ,coalesce( lpad(tclae.mes::text,2,''0''), '''') as mes
        ,tclae.exercicio_conciliacao
     FROM
        tmp_arrecadacao as TA
        LEFT JOIN tesouraria.conciliacao_lancamento_arrecadacao_estornada AS TCLAE
        ON(     TA.exercicio             = TCLAE.exercicio
            AND TA.cod_arrecadacao       = TCLAE.cod_arrecadacao
            AND TA.timestamp_arrecadacao = TCLAE.timestamp_arrecadacao
            AND TA.timestamp_estornada   = TCLAE.timestamp_estornada::text
        )
            LEFT JOIN tesouraria.conciliacao
                   ON tclae.cod_plano             = conciliacao.cod_plano
                  AND tclae.exercicio_conciliacao = conciliacao.exercicio
                  AND tclae.mes                   = conciliacao.mes
    WHERE ta.tipo_arrecadacao = ''D''
        AND EXISTS (
           SELECT true
             FROM tesouraria.arrecadacao_estornada as TTE
            WHERE ta.exercicio               = TTE.exercicio
              AND ta.cod_arrecadacao         = TTE.cod_arrecadacao
              AND ta.timestamp_arrecadacao   = TTE.timestamp_arrecadacao
              AND ta.timestamp_estornada     = TTE.timestamp_estornada::text
        )

    UNION

    -- ESTORNO DE ARRECADACAO DE RECEITA
     SELECT
        0 as cod_lote,
        TO_DATE(TAE.dt_boletim::VARCHAR,''dd/mm/yyyy'') as dt_lancamento,
        TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao,
        TAE.exercicio,
        TAE.conta_credito,
        CAST(''Estorno de Arrecadação da receita Boletim nr.''||TAE.cod_boletim as text) AS descricao,
        '''' as observacao,
        TAE.valor,
        ''C'' as tipo_valor,
        ''A'' as tipo,
        0 as sequencia,
        TAE.cod_entidade,
        CASE WHEN TCLAE.cod_plano IS NOT NULL
          THEN ''true''
          ELSE ''''
        END AS conciliar,
        ''A'' as tipo_movimentacao,
        TAE.cod_arrecadacao,
        TAE.cod_receita,
        0 as cod_bordero,
        TAE.timestamp_arrecadacao::text ,
        TAE.timestamp::text as timestamp_estornada,
        TAE.tipo_arrecadacao
        ,coalesce( lpad(tclae.mes::text,2,''0''), '''') as mes
        ,tclae.exercicio_conciliacao
     FROM
        tmp_arrecadacao_estornada AS TAE
        LEFT JOIN tesouraria.conciliacao_lancamento_arrecadacao_estornada AS TCLAE
        ON(     TAE.exercicio             = TCLAE.exercicio
            AND TAE.cod_arrecadacao       = TCLAE.cod_arrecadacao
            AND TAE.timestamp_arrecadacao = TCLAE.timestamp_arrecadacao
            AND TAE.timestamp             = TCLAE.timestamp_estornada
        )
            LEFT JOIN tesouraria.conciliacao
                   ON tclae.cod_plano             = conciliacao.cod_plano
                  AND tclae.exercicio_conciliacao = conciliacao.exercicio
                  AND tclae.mes                   = conciliacao.mes
    WHERE tae.tipo_arrecadacao = ''A''
        AND EXISTS (
           SELECT true
            FROM tesouraria.arrecadacao_estornada as TTE
           WHERE tae.exercicio               = TTE.exercicio
             AND tae.cod_arrecadacao         = TTE.cod_arrecadacao
             AND tae.timestamp_arrecadacao   = TTE.timestamp_arrecadacao
             AND tae.timestamp               = TTE.timestamp_estornada
        )

    UNION

    -- DEDUCAO DE RECEITA ou DEVOLUÇAO DE RECEITA
     SELECT
        0 as cod_lote,
        TO_DATE(TAE.dt_boletim::VARCHAR,''dd/mm/yyyy'') as dt_lancamento,
        TO_DATE(conciliacao.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao,
        TAE.exercicio,
        TAE.conta_credito,
        CASE WHEN ta.devolucao = ''f''
            THEN CAST(''Dedução da receita Boletim nr. ''||TAE.cod_boletim as text)
            ELSE CAST(''Devolução da receita Boletim nr. ''||TAE.cod_boletim as text)
        END as descricao,
        '''' as observacao,
        TAE.valor,
        ''C'' as tipo_valor,
        ''A'' as tipo,
        0 as sequencia,
        TAE.cod_entidade,
        CASE WHEN TCLA.cod_plano IS NOT NULL
          THEN ''true''
          ELSE ''''
        END AS conciliar,
        ''A'' as tipo_movimentacao,
        TAE.cod_arrecadacao,
        TAE.cod_receita,
        0 as cod_bordero,
        TAE.timestamp_arrecadacao::text ,
        TAE.timestamp::text as timestamp_estornada,
        TAE.tipo_arrecadacao
        ,coalesce( lpad(tcla.mes::text,2,''0''), '''') as mes
        ,tcla.exercicio_conciliacao
     FROM
        tmp_arrecadacao_estornada AS TAE
        LEFT JOIN tesouraria.conciliacao_lancamento_arrecadacao AS TCLA
        ON(     TAE.exercicio             = TCLA.exercicio
            AND TAE.cod_arrecadacao       = TCLA.cod_arrecadacao
            AND TAE.timestamp_arrecadacao = TCLA.timestamp_arrecadacao
        )
            LEFT JOIN tesouraria.conciliacao
                   ON tcla.cod_plano             = conciliacao.cod_plano
                  AND tcla.exercicio_conciliacao = conciliacao.exercicio
                  AND tcla.mes                   = conciliacao.mes
        LEFT JOIN tesouraria.arrecadacao as TA
        ON (      tae.exercicio               = TA.exercicio
              AND tae.cod_arrecadacao         = TA.cod_arrecadacao
              AND tae.timestamp_arrecadacao   = TA.timestamp_arrecadacao
        )
    WHERE tae.tipo_arrecadacao = ''D''
        AND EXISTS (
           SELECT true
            FROM tesouraria.arrecadacao as tta
           WHERE tae.exercicio               = TTA.exercicio
             AND tae.cod_arrecadacao         = TTA.cod_arrecadacao
             AND tae.timestamp_arrecadacao   = TTA.timestamp_arrecadacao
        )

    UNION
    --- BORDEROS
    SELECT
           0 as cod_lote,
           to_date(to_char(tb.timestamp_bordero, ''dd/mm/yyyy''),''dd/mm/yyyy'') as dt_lancamento,
           TO_DATE(ttp.dt_extrato::VARCHAR,''yyyy-mm-dd'') AS dt_conciliacao,
           tb.exercicio,
           tb.cod_plano,
           ''Pagamento de Bordero '' || TB.cod_bordero || ''/'' || TB.exercicio || '' - OP - '' || tesouraria.retorna_OPs(TTP.exercicio,TTP.cod_bordero,TTP.cod_entidade) as descricao,
           '''' as observacao,
           TTP.vl_pagamento as valor,
           ''C'' as tipo_valor,
           ''B'' as tipo,
           0 as sequencia,
           TB.cod_entidade,
           CASE WHEN ttp.cod_plano IS NOT NULL
             THEN ''true''
             ELSE ''''
           END AS conciliar,
           ''A'' as tipo_movimentacao,
           0 as cod_arrecadacao,
           0 as cod_receita,
           tb.cod_bordero,
           CAST('''' as text) as timestamp_arrecadacao,
           CAST('''' as text) as timestamp_estornada,
           CAST('''' as text) as tipo_arrecadacao
           ,coalesce( lpad(ttp.mes::text,2,''0''), '''') as mes
           ,ttp.exercicio_conciliacao
     FROM
         tesouraria.boletim AS BOLETIM
         INNER JOIN tesouraria.bordero AS TB  ON (
                 TB.cod_boletim       = BOLETIM.cod_boletim
             AND TB.cod_entidade      = BOLETIM.cod_entidade
             AND TB.exercicio_boletim = BOLETIM.exercicio
         )
         LEFT JOIN (
             SELECT
                 TTP.cod_bordero,
                 TTP.cod_entidade,
                 TTP.exercicio,
                 tclc.cod_plano,
                 tclc.mes,
                 tclc.exercicio_conciliacao,
                 conciliacao.dt_extrato,
                 sum(CVL.vl_lancamento) - coalesce( sum( CVLE.vl_estornado ), 0.00 ) AS vl_pagamento
             FROM
                  tesouraria.transacoes_pagamento  AS TTP
                 ,empenho.ordem_pagamento          AS EOP
                 ,empenho.pagamento_liquidacao     AS EPL
                 ,empenho.nota_liquidacao          AS ENL
                 ,empenho.empenho                  AS EE
                 ,empenho.pre_empenho              AS EPE
                 ,empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPLNLP
                 ,empenho.nota_liquidacao_paga                      AS ENLP
                 ,contabilidade.pagamento                           AS CP
            LEFT JOIN tesouraria.conciliacao_lancamento_contabil as tclc
            on(    cp.cod_lote         = tclc.cod_lote
               AND cp.tipo             = tclc.tipo
               AND cp.sequencia        = tclc.sequencia
               AND cp.exercicio        = tclc.exercicio
               AND cp.cod_entidade     = tclc.cod_entidade
               AND tclc.tipo_valor = ''C''
            )
            LEFT JOIN tesouraria.conciliacao
                   ON tclc.cod_plano             = conciliacao.cod_plano
                  AND tclc.exercicio_conciliacao = conciliacao.exercicio
                  AND tclc.mes                   = conciliacao.mes
                 LEFT JOIN( SELECT CVL.exercicio
                                  ,CVL.cod_entidade
                                  ,CVL.tipo
                                  ,CVL.cod_lote
                                  ,CVL.sequencia
                                  ,sum( vl_lancamento ) as vl_lancamento
                            FROM contabilidade.lancamento_empenho AS CLE
                                ,contabilidade.valor_lancamento   AS CVL
                            WHERE CLE.exercicio    = CVL.exercicio
                              AND CLE.cod_entidade = CVL.cod_entidade
                              AND CLE.tipo         = CVL.tipo
                              AND CLE.cod_lote     = CVL.cod_lote
                              AND CLE.sequencia    = CVL.sequencia
                              AND NOT CLE.estorno
                              AND CVL.tipo_valor = ''D''
                            GROUP BY CVL.exercicio
                                    ,CVL.cod_entidade
                                    ,CVL.tipo
                                    ,CVL.cod_lote
                                    ,CVL.sequencia
                            ORDER BY CVL.exercicio
                                    ,CVL.cod_entidade
                                    ,CVL.tipo
                                    ,CVL.cod_lote
                                    ,CVL.sequencia
                 ) AS CVL  ON( CP.exercicio    = CVL.exercicio
                           AND CP.cod_entidade = CVL.cod_entidade
                           AND CP.tipo         = CVL.tipo
                           AND CP.cod_lote     = CVL.cod_lote
                           AND CP.sequencia    = CVL.sequencia       )
                 LEFT JOIN( SELECT CVL.exercicio
                                  ,CVL.cod_entidade
                                  ,CVL.tipo
                                  ,CVL.cod_lote
                                  ,CVL.sequencia
                                  ,sum( vl_lancamento ) as vl_estornado
                            FROM contabilidade.lancamento_empenho AS CLE
                                ,contabilidade.valor_lancamento   AS CVL
                            WHERE CLE.exercicio    = CVL.exercicio
                              AND CLE.cod_entidade = CVL.cod_entidade
                              AND CLE.tipo         = CVL.tipo
                              AND CLE.cod_lote     = CVL.cod_lote
                              AND CLE.sequencia    = CVL.sequencia
                              AND CLE.estorno
                              AND CVL.tipo_valor = ''D''
                            GROUP BY CVL.exercicio
                                    ,CVL.cod_entidade
                                    ,CVL.tipo
                                    ,CVL.cod_lote
                                    ,CVL.sequencia
                            ORDER BY CVL.exercicio
                                    ,CVL.cod_entidade
                                    ,CVL.tipo
                                    ,CVL.cod_lote
                                    ,CVL.sequencia
                 ) AS CVLE ON( CP.exercicio   = CVLE.exercicio
                           AND CP.cod_entidade = CVLE.cod_entidade
                           AND CP.tipo         = CVLE.tipo
                           AND CP.cod_lote     = CVLE.cod_lote
                           AND CP.sequencia    = CVLE.sequencia       )
             WHERE
                 TTP.cod_ordem               = EOP.cod_ordem
             AND TTP.cod_entidade            = EOP.cod_entidade
             AND TTP.exercicio               = EOP.exercicio
             AND EOP.cod_ordem               = EPL.cod_ordem
             AND EOP.cod_entidade            = EPL.cod_entidade
             AND EOP.exercicio               = EPL.exercicio
             AND EPL.exercicio_liquidacao    = ENL.exercicio
             AND EPL.cod_nota                = ENL.cod_nota
             AND EPL.cod_entidade            = ENL.cod_entidade
             AND ENL.exercicio_empenho       = EE.exercicio
             AND ENL.cod_empenho             = EE.cod_empenho
             AND ENL.cod_entidade            = EE.cod_entidade
             AND EE.cod_pre_empenho          = EPE.cod_pre_empenho
             AND EE.exercicio                = EPE.exercicio
             AND EPL.exercicio_liquidacao    = EPLNLP.exercicio_liquidacao
             AND EPL.cod_nota                = EPLNLP.cod_nota
             AND EPL.cod_entidade            = EPLNLP.cod_entidade
             AND EPL.cod_ordem               = EPLNLP.cod_ordem
             AND EPL.exercicio               = EPLNLP.exercicio
             AND EPLNLP.exercicio_liquidacao = ENLP.exercicio
             AND EPLNLP.cod_nota             = ENLP.cod_nota
             AND EPLNLP.cod_entidade         = ENLP.cod_entidade
             AND EPLNLP.timestamp            = ENLP.timestamp
             AND ENLP.exercicio              = CP.exercicio_liquidacao
             AND ENLP.cod_nota               = CP.cod_nota
             AND ENLP.cod_entidade           = CP.cod_entidade
             AND ENLP.timestamp              = CP.timestamp
             GROUP BY
                 TTP.cod_bordero,
                 TTP.cod_entidade,
                 TTP.exercicio,
                 tclc.cod_plano,
                 tclc.mes,
                 tclc.exercicio_conciliacao,
                 conciliacao.dt_extrato
         )AS TTP ON (
                     TTP.cod_bordero    = TB.cod_bordero
             AND     TTP.cod_entidade   = TB.cod_entidade
             AND     TTP.exercicio      = TB.exercicio
         )
       WHERE   TB.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
           AND TB.cod_plano             = '||inCodPlano||'
           AND TB.cod_entidade          in ( '||stCodEntidade||' )
           AND TO_CHAR(BOLETIM.dt_boletim,''mm'') < TO_CHAR(TO_DATE( '''||stDtFinal||'''::VARCHAR, ''dd/mm/yyyy''),''mm'')
     ) as tbl
    ';

    --RAISE NOTICE '%', stSql || stFiltro;

    IF(stFiltro != '')THEN
        stSql := stSql || stFiltro;
    END IF;

    FOR reRegistro IN EXECUTE stSql
    LOOP
        RETURN next reRegistro;
    END LOOP;

    DROP TABLE tmp_deducao;
    DROP TABLE tmp_deducao_estornada;
    DROP TABLE tmp_arrecadacao_estornada;
    DROP TABLE tmp_arrecadacao;
    DROP TABLE tmp_estorno_arrecadacao;

END;

$_$;
