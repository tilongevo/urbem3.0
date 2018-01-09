CREATE OR REPLACE FUNCTION tesouraria.fn_conciliacao_movimentacao_pendente(character varying, character varying, character varying, character varying, character varying, character varying, integer, character varying)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $function$
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
          WHEN (tipo = ''B'') THEN vl_lancamento
          WHEN (tipo = ''T'' AND tipo_valor = ''C'') THEN vl_lancamento * -1
          WHEN (tipo = ''T'' AND tipo_valor = ''D'') THEN vl_lancamento * -1 
          WHEN (tipo = ''A'' and tipo_valor = ''C'' ) THEN vl_lancamento * -1
          WHEN (tipo = ''A'' and tipo_valor = ''D'' ) THEN vl_lancamento  
          WHEN (tipo = ''M'') THEN vl_lancamento * -1 
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
           TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao,
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
           END  as varchar) as descricao,           
           replace(trim(substring(coalesce(ENLP.observacao,''''),1,60)),'''','''') as observacao,           
           cast(enlp.vl_pago *-1 as numeric ) as vl_lancamento,           
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
            tesouraria.boletim as BOLETIM           
            INNER JOIN tesouraria.pagamento as P ON (
                BOLETIM.cod_boletim         = P.cod_boletim
            AND BOLETIM.exercicio           = P.exercicio_boletim
            AND BOLETIM.cod_entidade        = P.cod_entidade
            )
            INNER JOIN empenho.nota_liquidacao_paga as ENLP ON (
                P.cod_nota                  = ENLP.cod_nota
            AND P.exercicio                 = ENLP.exercicio
            AND P.cod_entidade              = ENLP.cod_entidade
            AND P.timestamp                 = ENLP.timestamp
            )
            INNER JOIN empenho.nota_liquidacao as ENL ON (
                ENLP.cod_nota               = ENL.cod_nota
            AND ENLP.exercicio              = ENL.exercicio
            AND ENLP.cod_entidade           = ENL.cod_entidade
            )
            INNER JOIN empenho.pagamento_liquidacao as EPL ON (
                EPL.cod_nota               = ENL.cod_nota
            AND EPL.exercicio_liquidacao   = ENL.exercicio
            AND EPL.cod_entidade           = ENL.cod_entidade
            )
            INNER JOIN empenho.pagamento_liquidacao_nota_liquidacao_paga as EPLNLP ON (
                EPL.cod_ordem               = EPLNLP.cod_ordem
            AND EPL.exercicio               = EPLNLP.exercicio
            AND EPL.cod_entidade            = EPLNLP.cod_entidade
            AND EPL.exercicio_liquidacao    = EPLNLP.exercicio_liquidacao
            AND EPL.cod_nota                = EPLNLP.cod_nota
            AND EPLNLP.timestamp            = ENLP.timestamp
            )
            INNER JOIN  contabilidade.pagamento as cp ON (
                ENLP.exercicio              = CP.exercicio_liquidacao
            AND ENLP.cod_nota               = CP.cod_nota
            AND ENLP.cod_entidade           = CP.cod_entidade
            AND ENLP.timestamp              = CP.timestamp
            )
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
            )                                                          
            LEFT JOIN tesouraria.transacoes_pagamento as TTP           
            ON (    ttp.cod_ordem    = EPLNLP.cod_ordem           
                AND ttp.cod_entidade = EPLNLP.cod_entidade           
                AND ttp.exercicio    = EPLNLP.exercicio           
            )           
        WHERE           
              
               CASE WHEN lc.mes IS NOT NULL                                            
             THEN CASE WHEN to_char( boletim.dt_boletim, ''yyyymm'' )::integer < (lc.exercicio_conciliacao||LPAD(lc.mes::text,2,''0''))::integer
                    THEN TRUE                                                      
                    ELSE FALSE                                                     
                  END                                                              
             ELSE TRUE                                                             
           END                                                                     
           AND p.cod_plano = '||inCodPlano||'                                    
           AND p.cod_entidade in ( '||stCodEntidade||' )
           AND to_char(P.timestamp,''yyyy'')::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer 
           AND lo.dt_lote = to_date(to_char(P.timestamp,''yyyy-mm-dd''),''yyyy-mm-dd'')          
           AND BOLETIM.dt_boletim < TO_DATE( '''||stDtInicial||'''::varchar, ''dd/mm/yyyy'' ) 
            
    UNION           
              
             
       SELECT            
           cp.cod_lote,           
           BOLETIM.dt_boletim as dt_lancamento,           
           TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao,
           boletim.exercicio,           
           p.cod_plano,           
           cast(           
           CASE WHEN TRIM(substring(ENLPA.observacao,1,60)) =  '''' THEN           
               CASE WHEN (ENL.exercicio_empenho < P.exercicio_boletim) THEN           
                    ''Estorno de Pagamento de RP n° '' || ENL.cod_empenho || ''/'' || ENL.exercicio_empenho           
               ELSE ''Estorno de Pagamento de Empenho n° '' || ENL.cod_empenho || ''/'' || ENL.exercicio_empenho           
               END           
           ELSE           
               CASE WHEN (ENL.exercicio_empenho < P.exercicio_boletim) THEN           
                    ''Estorno de Pagamento de RP n° '' || ENL.cod_empenho || ''/'' || ENL.exercicio_empenho            
               ELSE ''Estorno de Pagamento de Empenho n° '' || ENL.cod_empenho || ''/'' || ENL.exercicio_empenho            
               END           
           END  as varchar) as descricao,           
           replace(trim(substring(coalesce(ENLPA.observacao,''''),1,60)),'''','''')  as observacao,           
           enlpa.vl_anulado as vl_lancamento,           
           cast( ''C'' as varchar ) as tipo_valor,           
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
           CAST('''' as text ) as timestamp_arrecadacao,           
           CAST('''' as text ) as timestamp_estornada,           
           CAST('''' as text ) as tipo_arrecadacao           
           ,coalesce( lpad(lc.mes::text,2,''0''), '''') as mes           
           ,lc.exercicio_conciliacao
       FROM           
            tesouraria.boletim             as BOLETIM
            INNER JOIN tesouraria.pagamento_estornado AS PE ON (
                BOLETIM.cod_boletim         = PE.cod_boletim
            AND BOLETIM.exercicio           = PE.exercicio_boletim
            AND BOLETIM.cod_entidade        = PE.cod_entidade
            ) 
            
            INNER JOIN tesouraria.pagamento           as P ON (
                PE.cod_nota                 = P.cod_nota
            AND PE.exercicio                = P.exercicio
            AND PE.cod_entidade             = P.cod_entidade
            AND PE.timestamp                = P.timestamp
            )
            INNER JOIN empenho.nota_liquidacao_paga_anulada as ENLPA ON (
                PE.cod_nota                 = ENLPA.cod_nota
            AND PE.exercicio                = ENLPA.exercicio
            AND PE.cod_entidade             = ENLPA.cod_entidade
            AND PE.timestamp_anulado        = ENLPA.timestamp_anulada
            AND PE.timestamp                = ENLPA.timestamp
            )
            INNER JOIN empenho.nota_liquidacao_paga AS ENLP ON (
                ENLPA.cod_nota               = ENLP.cod_nota
            AND ENLPA.exercicio              = ENLP.exercicio
            AND ENLPA.cod_entidade           = ENLP.cod_entidade
            AND ENLPA.timestamp              = ENLP.timestamp
            )
            INNER JOIN empenho.nota_liquidacao as ENL ON (
                ENLP.cod_nota               = ENL.cod_nota
            AND ENLP.exercicio              = ENL.exercicio
            AND ENLP.cod_entidade           = ENL.cod_entidade
            )

            INNER JOIN contabilidade.pagamento_estorno as cpe ON (
                ENLPA.exercicio              = CPE.exercicio_liquidacao
            AND ENLPA.cod_nota               = CPE.cod_nota
            AND ENLPA.cod_entidade           = CPE.cod_entidade
            AND ENLPA.timestamp              = CPE.timestamp
            AND ENLPA.timestamp_anulada      = CPE.timestamp_anulada 
            )
            INNER JOIN empenho.pagamento_liquidacao_nota_liquidacao_paga as EPLNLP ON (
                EPLNLP.exercicio_liquidacao = ENLP.exercicio
            AND EPLNLP.cod_nota             = ENLP.cod_nota
            AND EPLNLP.cod_entidade         = ENLP.cod_entidade
            AND EPLNLP.timestamp            = ENLP.timestamp
            )
            INNER JOIN empenho.pagamento_liquidacao as EPL ON (
                EPL.cod_ordem               = EPLNLP.cod_ordem
            AND EPL.exercicio               = EPLNLP.exercicio
            AND EPL.cod_entidade            = EPLNLP.cod_entidade
            AND EPL.exercicio_liquidacao    = EPLNLP.exercicio_liquidacao
            AND EPL.cod_nota                = EPLNLP.cod_nota
            )

            INNER JOIN contabilidade.pagamento as cp           
            on(    cp.cod_lote         = cpe.cod_lote           
               AND cp.tipo             = cpe.tipo           
               AND cp.sequencia        = cpe.sequencia           
               AND cp.exercicio        = cpe.exercicio           
               AND cp.cod_entidade     = cpe.cod_entidade           
               AND cp.timestamp        = cpe.timestamp           
               AND cp.cod_nota         = cpe.cod_nota           
               AND cp.exercicio_liquidacao = cpe.exercicio_liquidacao     
            )                                          
            LEFT JOIN tesouraria.conciliacao_lancamento_contabil as lc           
            on(    cp.cod_lote         = lc.cod_lote           
               AND cp.tipo             = lc.tipo           
               AND cp.sequencia        = lc.sequencia           
               AND cp.exercicio        = lc.exercicio           
               AND cp.cod_entidade     = lc.cod_entidade           
               AND lc.tipo_valor = ''C''           
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
               AND le.estorno = ''true''                                                         
            )                                                                                   
            JOIN contabilidade.lote as lo                                                   
            ON (   le.cod_lote     = lo.cod_lote                                            
               AND le.cod_entidade = lo.cod_entidade                                        
               AND le.tipo         = lo.tipo                                                
               AND le.exercicio    = lo.exercicio                   
            )                                                         
            LEFT JOIN tesouraria.transacoes_pagamento as TTP           
            ON (    ttp.cod_ordem    = EPLNLP.cod_ordem           
                AND ttp.cod_entidade = EPLNLP.cod_entidade           
                AND ttp.exercicio    = EPLNLP.exercicio           
            )           
        WHERE           
              
               CASE WHEN lc.mes IS NOT NULL                                            
             THEN CASE WHEN to_char( boletim.dt_boletim, ''yyyymm'' )::integer < (lc.exercicio_conciliacao||LPAD(lc.mes::text,2,''0''))::integer
                    THEN TRUE                                                      
                    ELSE FALSE                                                     
                  END                                                              
             ELSE TRUE                                                             
           END                                                                     
              
           AND p.cod_plano = '||inCodPlano||'
           AND pe.cod_entidade in ( '||stCodEntidade||' )
           AND to_char(PE.timestamp_anulado,''yyyy'')::integer   BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
           AND BOLETIM.dt_boletim < TO_DATE( '''||stDtInicial||'''::varchar, ''dd/mm/yyyy'' ) 
           AND lo.dt_lote = to_date(to_char(PE.timestamp_anulado,''yyyy-mm-dd''),''yyyy-mm-dd'')          
              
    UNION           
              
   -- TRANSFERENCIAS           
   ------------------           
   -- BUSCA AS ARRECADAÇÕES EXTRA, PAGAMENTOS EXTRA, DEPÓSITOS/RETIRADAS, APLICAÇÃO E  RESGATES ( DEBITO )           
       SELECT           
            t.cod_lote           
           ,BOLETIM.dt_boletim as dt_lancamento           
           ,TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao
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
           AND CASE WHEN lc.mes IS NOT NULL                                            
             THEN CASE WHEN to_char( boletim.dt_boletim, ''yyyymm'' )::integer < (lc.exercicio_conciliacao||LPAD(lc.mes::text,2,''0''))::integer
                    THEN TRUE                                                      
                    ELSE FALSE                                                     
                  END                                                              
             ELSE TRUE                                                             
           END                                                                     
              
           AND T.cod_plano_debito    = '||inCodPlano||'                         
           AND T.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer       
           AND T.cod_entidade        in ( '||stCodEntidade||' )
           AND BOLETIM.dt_boletim < TO_DATE( '''||stDtInicial||'''::varchar, ''dd/mm/yyyy'' ) 
              
    UNION           
              
   -- BUSCA AS ARRECADAÇÕES EXTRA, PAGAMENTOS EXTRA, DEPÓSITOS/RETIRADAS, APLICAÇÃO E  RESGATES ( CREDITO )           
              
       SELECT          
            t.cod_lote           
           ,BOLETIM.dt_boletim as dt_lancamento           
           ,TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao
           ,t.exercicio           
           ,t.cod_plano_credito as cod_plano           
           ,trim(TTT.descricao || '' - CD:''||T.cod_plano_debito ||'' | CC:'' || T.cod_plano_credito) as descricao           
           ,replace(trim(substring(coalesce(T.observacao,''''),1,60)),'''','''') as observacao           
           ,T.valor *(-1) as vl_lancamento           
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
           AND CASE WHEN lc.mes IS NOT NULL                                            
             THEN CASE WHEN to_char( boletim.dt_boletim, ''yyyymm'' )::integer < (lc.exercicio_conciliacao||LPAD(lc.mes::text,2,''0''))::integer
                    THEN TRUE                                                      
                    ELSE FALSE                                                     
                  END                                                              
             ELSE TRUE                                                             
           END                                                                     
              
           AND T.cod_plano_credito    = '||inCodPlano||'                    
           AND T.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer       
           AND T.cod_entidade        in ( '||stCodEntidade||' )
           AND BOLETIM.dt_boletim < TO_DATE( '''||stDtInicial||''', ''dd/mm/yyyy'' ) 
              
    UNION                                                                                      
                                                                                               
    -- ESTORNO DE TRANSFERENCIAS  
     SELECT                                
            te.cod_lote_estorno           
           ,BOLETIM.dt_boletim as dt_lancamento           
           ,TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao
           ,te.exercicio           
           ,t.cod_plano_debito as cod_plano           
           ,trim('' Estorno de '' || TTT.descricao || '' - CD: ''||T.cod_plano_credito ||'' | CC: '' || T.cod_plano_debito ) as descricao   
           ,replace(trim(substring(coalesce(T.observacao,''''),1,60)),'''','''') as observacao           
           ,TE.valor * (-1) as vl_lancamento           
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
          TTT.cod_tipo          = T.cod_tipo        AND              
                                                                       
          BOLETIM.cod_boletim   = TE.cod_boletim     AND              
          BOLETIM.exercicio     = TE.exercicio       AND              
          BOLETIM.cod_entidade  = TE.cod_entidade                  
           AND CASE WHEN lc.mes IS NOT NULL                                            
             THEN CASE WHEN to_char( boletim.dt_boletim, ''yyyymm'' )::integer < (lc.exercicio_conciliacao||LPAD(lc.mes::text,2,''0''))::integer
                    THEN TRUE                                                      
                    ELSE FALSE                                                     
                  END                                                              
             ELSE TRUE                                                             
           END                                                                     
                                                                           
           AND T.cod_plano_debito    = '||inCodPlano||'                   
           AND TE.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
           AND TE.cod_entidade        in ( '||stCodEntidade||' )
           AND BOLETIM.dt_boletim < TO_DATE( '''||stDtInicial||'''::varchar, ''dd/mm/yyyy'' ) 
                                                                                                   
   UNION                                                                                           
                                                                                                   
     SELECT                                
            te.cod_lote_estorno           
           ,BOLETIM.dt_boletim as dt_lancamento           
           ,TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao
           ,te.exercicio           
           ,t.cod_plano_credito as cod_plano           
           ,trim('' Estorno de '' || TTT.descricao || '' - CD: ''||T.cod_plano_credito ||'' | CC: '' || T.cod_plano_debito ) as descricao   
           ,replace(trim(substring(coalesce(T.observacao,''''),1,60)),'''','''') as observacao           
           ,TE.valor * (-1) as vl_lancamento           
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
          TTT.cod_tipo          = T.cod_tipo        AND              
                                                                       
          BOLETIM.cod_boletim   = TE.cod_boletim     AND              
          BOLETIM.exercicio     = TE.exercicio       AND              
          BOLETIM.cod_entidade  = TE.cod_entidade                  
           AND CASE WHEN lc.mes IS NOT NULL                                            
             THEN CASE WHEN to_char( boletim.dt_boletim, ''yyyymm'' )::integer < (lc.exercicio_conciliacao||LPAD(lc.mes::text,2,''0''))::integer
                    THEN TRUE                                                      
                    ELSE FALSE                                                     
                  END                                                              
             ELSE TRUE                                                             
           END                                                                     
                                                                           
           AND T.cod_plano_credito    = '||inCodPlano||'                   
           AND TE.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer
           AND TE.cod_entidade        in ( '||stCodEntidade||' )
           AND BOLETIM.dt_boletim < TO_DATE( '''||stDtInicial||'''::varchar, ''dd/mm/yyyy'' ) 
                                                                                                   
   UNION                                                                                           
   -- ARRECADACOES                                                                                         
   -- ARRECADACAO DE RECEITA                                                                   
    SELECT                                                                                     
       0 as cod_lote,                                                                          
       TO_DATE(TA.dt_boletim::varchar,''dd/mm/yyyy'') as dt_lancamento,                                                   
       TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao,
       TA.exercicio,                                                                           
       TA.conta_debito,                                                                        
       CAST( ''Arrecadação da receita Boletim nr. ''||TA.cod_boletim as varchar ) as descricao,  
       '''' as observacao,                                                                       
       TA.valor * (-1) AS valor,                                                                               
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
       AND CASE WHEN TCLA.mes IS NOT NULL                                                        
             THEN CASE WHEN to_char( TO_DATE(TA.dt_boletim::varchar,''dd/mm/yyyy''), ''yyyymm'' )::integer < (TCLA.exercicio_conciliacao||LPAD(TCLA.mes::text,2,''0''))::integer
                   THEN TRUE                                                                      
                   ELSE FALSE                                                                     
                   END                                                                             
               ELSE TRUE                                                                            
           END                                                                                   
                                                                            
   UNION                                                               
                                                                    
   -- ESTORNO DE DEDUCAO                                                                       
    SELECT                                                                                     
       0 as cod_lote,                                                                          
       TO_DATE(TA.dt_boletim::varchar,''dd/mm/yyyy'') as dt_lancamento,                                                   
       TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao,
       TA.exercicio,                                                                           
       TA.conta_debito,                                                                        
       CAST( ''Estorno de Dedução de receita Boletim nr. ''||TA.cod_boletim as varchar) as descricao, 
       '''' as observacao,                                                                       
       TA.valor * (-1) AS valor,                                                                               
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
       AND CASE WHEN TCLAE.mes IS NOT NULL                                                        
             THEN CASE WHEN to_char( TO_DATE(TA.dt_boletim::varchar,''dd/mm/yyyy''), ''yyyymm'' )::integer < (TCLAE.exercicio_conciliacao||LPAD(TCLAE.mes::text,2,''0''))::integer
                   THEN TRUE                                                                      
                   ELSE FALSE                                                                     
                   END                                                                             
               ELSE TRUE                                                                            
           END                                                                                   
                                                                                                        
   UNION                                                                                                
                                                                                                        
   -- ESTORNO DE ARRECADACAO DE RECEITA                                                                 
    SELECT                                                                                     
       0 as cod_lote,                                                                          
       TO_DATE(TAE.dt_boletim::varchar,''dd/mm/yyyy'') as dt_lancamento,                                                 
       TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao,
       TAE.exercicio,                                                                          
       TAE.conta_credito,                                                                      
       CAST(''Estorno de Arrecadação da receita Boletim nr.''||TAE.cod_boletim as text) AS descricao, 
       '''' as observacao,                                                                       
       TAE.valor * (-1) AS valor,                                                                              
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
       AND CASE WHEN TCLAE.mes IS NOT NULL                                                          
             THEN CASE WHEN to_char( TO_DATE(TAE.dt_boletim::varchar,''dd/mm/yyyy''), ''yyyymm'' )::integer < (TCLAE.exercicio_conciliacao||LPAD(TCLAE.mes::text,2,''0''))::integer
                   THEN TRUE                                                                        
                   ELSE FALSE                                                                       
                   END                                                                              
               ELSE TRUE                                                                            
           END                                                                                      
                                                                                                    
   UNION                                                                             
                                                                                     
   -- DEDUCAO DE RECEITA ou DEVOLUÇAO DE RECEITA                                               
    SELECT                                                                                     
       0 as cod_lote,                                                                          
       TO_DATE(TAE.dt_boletim::varchar,''dd/mm/yyyy'') as dt_lancamento,                                                  
       TO_DATE(conciliacao.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao,
       TAE.exercicio,                                                                          
       TAE.conta_credito,                                                                      
       CASE WHEN ta.devolucao = ''f''                                                        
           THEN CAST(''Dedução da receita Boletim nr. ''||TAE.cod_boletim as text)    
           ELSE CAST(''Devolução da receita Boletim nr. ''||TAE.cod_boletim as text)   
       END as descricao,                                                                       
       '''' as observacao,                                                                       
       TAE.valor * (-1) AS valor,                                                                              
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
       AND CASE WHEN TCLA.mes IS NOT NULL                                                       
             THEN CASE WHEN to_char( TO_DATE(TAE.dt_boletim::varchar,''dd/mm/yyyy''), ''yyyymm'' )::integer < (TCLA.exercicio_conciliacao||LPAD(TCLA.mes::text,2,''0''))::integer
                   THEN TRUE                                                                      
                   ELSE FALSE                                                                     
                   END                                                                             
               ELSE TRUE                                                                            
           END                                                                                   
                                                                                               
   UNION                                                                             
   --- BORDEROS                                                    
   SELECT                                                                           
          0 as cod_lote,                                                                        
          to_date(to_char(tb.timestamp_bordero, ''dd/mm/yyyy''),''dd/mm/yyyy'') as dt_lancamento,            
          TO_DATE(ttp.dt_extrato::varchar,''yyyy-mm-dd'') AS dt_conciliacao,
          tb.exercicio,                                                                        
          tb.cod_plano,                                                                        
          ''Pagamento de Bordero '' || TB.cod_bordero || ''/'' || TB.exercicio || '' - OP - '' || tesouraria.retorna_OPs(TTP.exercicio,TTP.cod_bordero,TTP.cod_entidade) as descricao,                      
          '''' as observacao,                                                                        
          TTP.vl_pagamento*(-1) as valor,                                                             
          ''C'' as tipo_valor,                                                                      
          '''' as tipo,                                                                            
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
                 INNER JOIN empenho.ordem_pagamento          AS EOP ON (
                     TTP.cod_ordem               = EOP.cod_ordem                                                       
                 AND TTP.cod_entidade            = EOP.cod_entidade                                                       
                 AND TTP.exercicio               = EOP.exercicio                                                       
                 )
                 INNER JOIN empenho.pagamento_liquidacao     AS EPL ON (
                     EOP.cod_ordem               = EPL.cod_ordem                                                       
                 AND EOP.cod_entidade            = EPL.cod_entidade                                                       
                 AND EOP.exercicio               = EPL.exercicio                                                       
                 )
                 INNER JOIN empenho.nota_liquidacao          AS ENL ON (
                     EPL.exercicio_liquidacao    = ENL.exercicio                                                       
                 AND EPL.cod_nota                = ENL.cod_nota                                                       
                 AND EPL.cod_entidade            = ENL.cod_entidade                                                       
                 )
                 INNER JOIN empenho.empenho                  AS EE ON (
                     ENL.exercicio_empenho       = EE.exercicio                                                       
                 AND ENL.cod_empenho             = EE.cod_empenho                                                       
                 AND ENL.cod_entidade            = EE.cod_entidade                                                       
                 )
                 INNER JOIN empenho.pre_empenho              AS EPE ON (
                     EE.cod_pre_empenho          = EPE.cod_pre_empenho                                                       
                 AND EE.exercicio                = EPE.exercicio                                                       
                 )
                 INNER JOIN empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPLNLP ON (
                     EPL.exercicio_liquidacao    = EPLNLP.exercicio_liquidacao                                                       
                 AND EPL.cod_nota                = EPLNLP.cod_nota                                                       
                 AND EPL.cod_entidade            = EPLNLP.cod_entidade                                                       
                 AND EPL.cod_ordem               = EPLNLP.cod_ordem                                                       
                 AND EPL.exercicio               = EPLNLP.exercicio
                 )
                 INNER JOIN empenho.nota_liquidacao_paga                      AS ENLP ON (
                     EPLNLP.exercicio_liquidacao = ENLP.exercicio                                                       
                 AND EPLNLP.cod_nota             = ENLP.cod_nota                                                       
                 AND EPLNLP.cod_entidade         = ENLP.cod_entidade                                                       
                 AND EPLNLP.timestamp            = ENLP.timestamp                                                       
                 )
                 INNER JOIN contabilidade.pagamento                           AS CP ON (
                     ENLP.exercicio              = CP.exercicio_liquidacao                                                       
                 AND ENLP.cod_nota               = CP.cod_nota                                                       
                 AND ENLP.cod_entidade           = CP.cod_entidade                                                       
                 AND ENLP.timestamp              = CP.timestamp                                                       
                 )
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
                    INNER JOIN contabilidade.valor_lancamento   AS CVL
                           ON CLE.exercicio    = CVL.exercicio                                                       
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
                   INNER JOIN contabilidade.valor_lancamento   AS CVL                                                       
                           ON CLE.exercicio    = CVL.exercicio                                                       
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
             ) AS CVLE ON( CP.exercicio   = CVLE.exercicio                                                       
                       AND CP.cod_entidade = CVLE.cod_entidade                                                       
                       AND CP.tipo         = CVLE.tipo                                                       
                       AND CP.cod_lote     = CVLE.cod_lote                                                       
                       AND CP.sequencia    = CVLE.sequencia       )                                                       
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
      WHERE                                                       
           CASE WHEN ttp.mes IS NOT NULL                                            
             THEN CASE WHEN to_char( boletim.dt_boletim, ''yyyymm'' )::integer < (ttp.exercicio_conciliacao||LPAD(ttp.mes::text,2,''0''))::integer
                    THEN TRUE                                                      
                    ELSE FALSE                                                     
                  END                                                              
             ELSE TRUE                                                             
           END                                                                     
          AND TB.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer                                                  
          AND TB.cod_plano             = '||inCodPlano||'                                               
          AND TB.cod_entidade          in ( '||stCodEntidade||' )
          AND BOLETIM.dt_boletim < TO_DATE( '''||stDtInicial||'''::varchar, ''dd/mm/yyyy'' ) 
    ) as tbl 
   ';
   IF(stFiltro != '')THEN
       stSql := stSql || stFiltro;
   END IF;

   stSql := stSql || '                                                                            
--    WHERE  exercicio <= '''||stExercicio||''' AND  dt_lancamento < TO_DATE( '''||stDtInicial||''', ''dd/mm/yyyy'' ) AND  cod_plano = '||inCodPlano||'  AND  (mes = '''||stMes||''' OR conciliar != ''true'') 
          UNION 
          SELECT                                                                            
             '''' as ordem,    
             TO_CHAR(TCLM.dt_lancamento,''dd/mm/yyyy'') as dt_lancamento,                                                          
             CAST(CASE WHEN conciliado = true
                       THEN TO_CHAR(tclm.dt_conciliacao,''dd/mm/yyyy'')
                       ELSE ''''::VARCHAR
                  END AS VARCHAR) AS dt_conciliacao,
             --TO_CHAR(tclm.dt_conciliacao,''dd/mm/yyyy'') AS dt_conciliacao, 
             TCLM.descricao,                                                                
             TCLM.vl_lancamento,                                                            
             TCLM.vl_lancamento as vl_original,                                                            
             TCLM.tipo_valor,
             CASE WHEN conciliado = true
                                 THEN ''true''
                                 ELSE ''''
                            END as conciliar,                                                          
             0 as cod_lote,                                                                 
             ''M'' as tipo,                                                                   
             TCLM.sequencia,                                                                
             0 AS cod_entidade,                                                             
             ''M'' as tipo_movimentacao,                                                      
             TCLM.cod_plano,                                                                
             0 AS cod_arrecadacao,                                                          
             0 AS cod_receita,                                                              
             0 AS cod_bordero,                                                              
             CAST('''' as text) AS timestamp_arrecadacao,                                   
             CAST('''' as text) AS timestamp_estornada,                                   
             CAST('''' as text) AS tipo_arrecadacao                                         
             ,coalesce ( lpad(tclm.mes::text,2,''0''), '''' ) as mes
             , '''' as id                 
             ,tclm.exercicio AS exercicio_conciliacao
          FROM                                                                              
             tesouraria.conciliacao_lancamento_manual AS TCLM                               
          WHERE tclm.exercicio::integer BETWEEN '''||stExercicio||'''::integer-1 AND '''||stExercicio||'''::integer   
            AND tclm.cod_plano     = '||inCodPlano||'
            AND tclm.dt_lancamento < TO_DATE( '''||stDtInicial||'''::varchar, ''dd/mm/yyyy'' ) 
            AND (('''||stExercicio||stMes||''' BETWEEN TO_CHAR(dt_lancamento,''yyyymm'') AND TO_CHAR(dt_conciliacao,''yyyymm''))
                   OR (conciliado != true))

           ORDER BY dt_lancamento
';

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

$function$
