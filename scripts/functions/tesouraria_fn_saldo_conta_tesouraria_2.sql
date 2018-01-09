CREATE OR REPLACE FUNCTION tesouraria.fn_saldo_conta_tesouraria(character varying, integer, character varying, character varying)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$
DECLARE
    stExercicio         ALIAS FOR $1;
    inCodPlano          ALIAS FOR $2;
    stDtInicial         ALIAS FOR $3;
    stDtFinal           ALIAS FOR $4;

    stSql               VARCHAR   := '';
    boTmpArrecadacao    BOOLEAN;
    crCursor            REFCURSOR;


    nuValorImplantado   NUMERIC   := 0.00;
    nuVlTransferencia   NUMERIC   := 0.00;
    nuVlTransferenciaDeb NUMERIC   := 0.00;
    nuVlTransferenciaEstornadaDeb NUMERIC   := 0.00;
    nuVlTransferenciaCred   NUMERIC   := 0.00;
    nuVlTransferenciaEstornadaCred NUMERIC   := 0.00;
    nuVlPago            NUMERIC   := 0.00;
    nuVlPagoEstornado   NUMERIC   := 0.00;
    nuValorTesouraria   NUMERIC   := 0.00;
    nuVlArrecadacao     NUMERIC   := 0.00;
    nuVlArrecadacaoEstornada   NUMERIC   := 0.00;

BEGIN

    SELECT vl_saldo INTO nuValorImplantado FROM tesouraria.saldo_tesouraria WHERE cod_plano = inCodPlano AND exercicio = stExercicio;

    --
    -- Contabiliza valores arrecadados apenas se a data final for superior ao primeiro dia do ano
    --
    IF( TO_DATE( stDtFinal, 'dd/mm/yyyy' ) != TO_DATE( '01/01/'||stExercicio, 'dd/mm/yyyy' ) ) THEN


        stSql := '
        SELECT tesouraria.fn_listar_arrecadacao('' AND TB.exercicio = '''''||stExercicio||'''''
                                                     AND TB.dt_boletim >= TO_DATE( '''''||stDtInicial||''''', ''''dd/mm/yyyy'''' )
                                                     AND TB.dt_boletim <= TO_DATE( '''''||stDtFinal  ||''''', ''''dd/mm/yyyy'''' )
                                                     AND TA.cod_plano = '||inCodPlano||'    ''
                                               ,'' AND TB.exercicio = '''''||stExercicio||'''''
                                                     AND TB.dt_boletim >= TO_DATE( '''''||stDtInicial||''''', ''''dd/mm/yyyy'''' )
                                                     AND TB.dt_boletim <= TO_DATE( '''''||stDtFinal  ||''''', ''''dd/mm/yyyy'''' )
                                                     AND TA.cod_plano = '||inCodPlano||'    ''
        );';
        EXECUTE stSql;


        --
        -- Calcula Valor Transferencia
        --
        SELECT SUM(CVL.vl_lancamento) INTO nuVlTransferenciaDeb
        FROM tesouraria.transferencia       AS TT
            ,contabilidade.valor_lancamento AS CVL
          -- Join com valor_lancamento
        WHERE TT.exercicio    = CVL.exercicio
          AND TT.cod_entidade = CVL.cod_entidade
          AND TT.tipo         = CVL.tipo
          AND TT.cod_lote     = CVL.cod_lote
          AND CVL.tipo_valor  = 'D'
          AND TO_DATE(TT.timestamp_transferencia,'yyyy-mm-dd' ) >= TO_DATE( stDtInicial, 'dd/mm/yyyy' )
          AND TO_DATE(TT.timestamp_transferencia,'yyyy-mm-dd' ) <= TO_DATE( stDtFinal  , 'dd/mm/yyyy' )
          AND TT.exercicio = stExercicio
          AND contabilidade.fn_recupera_conta_lancamento( CVL.exercicio
                                                         ,CVL.cod_entidade
                                                         ,CVL.cod_lote
                                                         ,CVL.tipo
                                                         ,CVL.sequencia
                                                         ,'D'
              ) = inCodPlano
        ;


        SELECT SUM(CVL.vl_lancamento) INTO nuVlTransferenciaEstornadaDeb
        FROM tesouraria.transferencia           AS TT
            ,tesouraria.transferencia_estornada AS TTE
            ,contabilidade.valor_lancamento     AS CVL
        WHERE TT.exercicio    = TTE.exercicio
          AND TT.cod_entidade = TTE.cod_entidade
          AND TT.tipo         = TTE.tipo
          AND TT.cod_lote     = TTE.cod_lote_transferencia
          -- Join com valor_lancamento
          AND TTE.exercicio    = CVL.exercicio
          AND TTE.cod_entidade = CVL.cod_entidade
          AND TTE.tipo         = CVL.tipo
          AND TTE.cod_lote     = CVL.cod_lote
          AND CVL.tipo_valor  = 'D'
          AND TO_DATE(TTE.timestamp_estornada,'yyyy-mm-dd' ) >= TO_DATE( stDtInicial, 'dd/mm/yyyy' )
          AND TO_DATE(TTE.timestamp_estornada,'yyyy-mm-dd' ) <= TO_DATE( stDtFinal  , 'dd/mm/yyyy' )
          AND TT.exercicio = stExercicio
          AND contabilidade.fn_recupera_conta_lancamento( CVL.exercicio
                                                         ,CVL.cod_entidade
                                                         ,CVL.cod_lote
                                                         ,CVL.tipo
                                                         ,CVL.sequencia
                                                         ,'D'
              ) = inCodPlano
        ;


        SELECT SUM(CVL.vl_lancamento) INTO nuVlTransferenciaCred
        FROM tesouraria.transferencia       AS TT
            ,contabilidade.valor_lancamento AS CVL
          -- Join com valor_lancamento
        WHERE TT.exercicio    = CVL.exercicio
          AND TT.cod_entidade = CVL.cod_entidade
          AND TT.tipo         = CVL.tipo
          AND TT.cod_lote     = CVL.cod_lote
          AND CVL.tipo_valor  = 'D'
          AND TO_DATE(TT.timestamp_transferencia,'yyyy-mm-dd' ) >= TO_DATE( stDtInicial, 'dd/mm/yyyy' )
          AND TO_DATE(TT.timestamp_transferencia,'yyyy-mm-dd' ) <= TO_DATE( stDtFinal  , 'dd/mm/yyyy' )
          AND TT.exercicio = stExercicio
          AND contabilidade.fn_recupera_conta_lancamento( CVL.exercicio
                                                         ,CVL.cod_entidade
                                                         ,CVL.cod_lote
                                                         ,CVL.tipo
                                                         ,CVL.sequencia
                                                         ,'C'
              ) = inCodPlano
        ;


        SELECT SUM(CVL.vl_lancamento) INTO nuVlTransferenciaEstornadaCred
        FROM tesouraria.transferencia           AS TT
            ,tesouraria.transferencia_estornada AS TTE
            ,contabilidade.valor_lancamento     AS CVL
        WHERE TT.exercicio    = TTE.exercicio
          AND TT.cod_entidade = TTE.cod_entidade
          AND TT.tipo         = TTE.tipo
          AND TT.cod_lote     = TTE.cod_lote_transferencia
          -- Join com valor_lancamento
          AND TTE.exercicio    = CVL.exercicio
          AND TTE.cod_entidade = CVL.cod_entidade
          AND TTE.tipo         = CVL.tipo
          AND TTE.cod_lote     = CVL.cod_lote
          AND CVL.tipo_valor  = 'D'
          AND TO_DATE(TTE.timestamp_estornada,'yyyy-mm-dd' ) >= TO_DATE( stDtInicial, 'dd/mm/yyyy' )
          AND TO_DATE(TTE.timestamp_estornada,'yyyy-mm-dd' ) <= TO_DATE( stDtFinal  , 'dd/mm/yyyy' )
          AND TT.exercicio = stExercicio
          AND contabilidade.fn_recupera_conta_lancamento( CVL.exercicio
                                                         ,CVL.cod_entidade
                                                         ,CVL.cod_lote
                                                         ,CVL.tipo
                                                         ,CVL.sequencia
                                                         ,'C'
              ) = inCodPlano
        ;


        SELECT SUM(ENLP.vl_pago) INTO nuVlPago
        FROM tesouraria.pagamento                              AS TP
            ,empenho.ordem_pagamento                           AS EOP
            ,empenho.pagamento_liquidacao                      AS EPL
            ,empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPNLP
            ,empenho.nota_liquidacao_paga                      AS ENLP
            ,contabilidade.pagamento                           AS CP
            ,contabilidade.lancamento_empenho                  AS CLE
            ,contabilidade.conta_credito                       AS CCC
          -- Join com ordem_pagamento
        WHERE TP.exercicio    = EOP.exercicio
          AND TP.cod_entidade = EOP.cod_entidade
          AND TP.cod_ordem    = EOP.cod_ordem
          -- Join com pagamento_liquidacao
          AND EOP.exercicio    = EPL.exercicio
          AND EOP.cod_entidade = EPL.cod_entidade
          AND EOP.cod_ordem    = EPL.cod_ordem
          -- Join com pagamento_liquidacao_nota_liquidacao_paga
          AND EPL.exercicio            = EPNLP.exercicio
          AND EPL.exercicio_liquidacao = EPNLP.exercicio_liquidacao
          AND EPL.cod_entidade         = EPNLP.cod_entidade
          AND EPL.cod_ordem            = EPNLP.cod_ordem
          AND EPL.cod_nota             = EPNLP.cod_nota
          -- Join com nota_liquidacao_paga
          AND EPNLP.exercicio_liquidacao = ENLP.exercicio
          AND EPNLP.cod_entidade         = ENLP.cod_entidade
          AND EPNLP.cod_nota             = ENLP.cod_nota
          AND EPNLP.timestamp            = ENLP.timestamp
          -- Join com pagamento
          AND ENLP.exercicio             = CP.exercicio_liquidacao
          AND ENLP.cod_entidade          = CP.cod_entidade
          AND ENLP.cod_nota              = CP.cod_nota
          AND ENLP.timestamp             = CP.timestamp
          -- Join com lancamento_empenho
          AND CP.exercicio               = CLE.exercicio
          AND CP.cod_entidade            = CLE.cod_entidade
          AND CP.cod_lote                = CLE.cod_lote
          AND CP.tipo                    = CLE.tipo
          AND CP.sequencia               = CLE.sequencia
          AND NOT CLE.estorno
          -- Joi com conta_credito
          AND CLE.exercicio              = CCC.exercicio
          AND CLE.cod_entidade           = CCC.cod_entidade
          AND CLE.cod_lote               = CCC.cod_lote
          AND CLE.tipo                   = CCC.tipo
          AND CLE.sequencia              = CCC.sequencia
          -- Filtros
          AND TO_DATE(TP.timestamp_pagamento, 'yyyy/mm/dd' ) >= TO_DATE( stDtInicial, 'dd/mm/yyyy' )
          AND TO_DATE(TP.timestamp_pagamento, 'yyyy/mm/dd' ) <= TO_DATE( stDtFinal  , 'dd/mm/yyyy' )
          AND TP.exercicio   = stExercicio
          AND CCC.cod_plano  = inCodPlano
          AND CCC.tipo_valor = 'C'
        ;


        SELECT SUM(ENLP.vl_pago) INTO nuVlPagoEstornado
        FROM tesouraria.pagamento                              AS TP
            ,tesouraria.pagamento_estornado                    AS TPE
            ,empenho.ordem_pagamento                           AS EOP
            ,empenho.pagamento_liquidacao                      AS EPL
            ,empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPNLP
            ,empenho.nota_liquidacao_paga                      AS ENLP
            ,empenho.nota_liquidacao_paga_anulada              AS ENLPA
            ,contabilidade.pagamento                           AS CP
            ,contabilidade.lancamento_empenho                  AS CLE
            ,contabilidade.conta_debito                        AS CCD
          -- Join com pagamento_estornado
        WHERE TP.exercicio    = TPE.exercicio
          AND TP.cod_entidade = TPE.cod_entidade
          AND TP.cod_ordem    = TPE.cod_ordem
          AND TP.timestamp_pagamento = TPE.timestamp_pagamento
          -- Join com ordem_pagamento
          AND TP.exercicio    = EOP.exercicio
          AND TP.cod_entidade = EOP.cod_entidade
          AND TP.cod_ordem    = EOP.cod_ordem
          -- Join com pagamento_liquidacao
          AND EOP.exercicio    = EPL.exercicio
          AND EOP.cod_entidade = EPL.cod_entidade
          AND EOP.cod_ordem    = EPL.cod_ordem
          -- Join com pagamento_liquidacao_nota_liquidacao_paga
          AND EPL.exercicio            = EPNLP.exercicio
          AND EPL.exercicio_liquidacao = EPNLP.exercicio_liquidacao
          AND EPL.cod_entidade         = EPNLP.cod_entidade
          AND EPL.cod_ordem            = EPNLP.cod_ordem
          AND EPL.cod_nota             = EPNLP.cod_nota
          -- Join com nota_liquidacao_paga
          AND EPNLP.exercicio_liquidacao = ENLP.exercicio
          AND EPNLP.cod_entidade         = ENLP.cod_entidade
          AND EPNLP.cod_nota             = ENLP.cod_nota
          AND EPNLP.timestamp            = ENLP.timestamp
          -- Join com nota_liquidacao_paga_anulada
          AND ENLP.exercicio            = ENLPA.exercicio
          AND ENLP.cod_entidade         = ENLPA.cod_entidade
          AND ENLP.cod_nota             = ENLPA.cod_nota
          AND ENLP.timestamp            = ENLPA.timestamp
          -- Join com pagamento
          AND ENLP.exercicio             = CP.exercicio_liquidacao
          AND ENLP.cod_entidade          = CP.cod_entidade
          AND ENLP.cod_nota              = CP.cod_nota
          AND ENLP.timestamp             = CP.timestamp
          -- Join com lancamento_empenho
          AND CP.exercicio               = CLE.exercicio
          AND CP.cod_entidade            = CLE.cod_entidade
          AND CP.cod_lote                = CLE.cod_lote
          AND CP.tipo                    = CLE.tipo
          AND CP.sequencia               = CLE.sequencia
          AND CLE.estorno
          -- Joi com conta_credito
          AND CLE.exercicio              = CCD.exercicio
          AND CLE.cod_entidade           = CCD.cod_entidade
          AND CLE.cod_lote               = CCD.cod_lote
          AND CLE.tipo                   = CCD.tipo
          AND CLE.sequencia              = CCD.sequencia
          -- Filtros
          AND TO_DATE(TPE.timestamp_estornado, 'yyyy/mm/dd' ) >= TO_DATE( stDtInicial, 'dd/mm/yyyy' )
          AND TO_DATE(TPE.timestamp_estornado, 'yyyy/mm/dd' ) <= TO_DATE( stDtFinal  , 'dd/mm/yyyy' )
          AND TP.exercicio   = stExercicio
          AND CCD.cod_plano  = inCodPlano
          AND CCD.tipo_valor = 'D'
        ;

        stSql := '
            SELECT SUM( valor - vl_desconto + vl_juros + vl_multa ) as valor
            FROM tmp_arrecadacao
            WHERE conta_debito = '||inCodPlano;
        OPEN crCursor FOR EXECUTE stSql;
          FETCH crCursor INTO nuVlArrecadacao;
        CLOSE crCursor;

        stSql := '
            SELECT SUM( valor - vl_desconto + vl_juros + vl_multa ) as valor
            FROM tmp_arrecadacao_estornada
            WHERE conta_credito = '||inCodPlano;
        OPEN crCursor FOR EXECUTE stSql;
          FETCH crCursor INTO nuVlArrecadacaoEstornada;
        CLOSE crCursor;

    END IF;


nuVlTransferencia := coalesce( nuVlTransferenciaCred, 0.00 ) + coalesce( nuVlTransferenciaEstornadaCred, 0.00 ) - coalesce( nuVlTransferenciaDeb, 0.00 ) - coalesce( nuVlTransferenciaEstornadaDeb, 0.00 );
nuVlPago          := coalesce( nuVlPago         , 0.00 ) - coalesce( nuVlPagoEstornado         , 0.00 );
nuVlArrecadacao   := coalesce( nuVlArrecadacao  , 0.00 ) - coalesce( nuVlArrecadacaoEstornada  , 0.00 );
nuValorTesouraria := nuVlArrecadacao - nuVlTransferencia - nuVlPago;

--RAISE NOTICE 'Pago: %', nuVlPago;
--RAISE NOTICE 'Est.: %', nuVlPagoEstornado;
--
--RAISE NOTICE 'Valor Implant.: %', nuValorImplantado;
--RAISE NOTICE 'Valor Trans.  : %', nuVlTransferencia;
--RAISE NOTICE 'Valor Pago.   : %', nuVlPago;
--RAISE NOTICE 'Valor Arrecad.: %', nuVlArrecadacao;

DROP TABLE tmp_arrecadacao;
DROP TABLE tmp_arrecadacao_estornada;
DROP TABLE tmp_deducao;

RETURN nuValorImplantado + nuValorTesouraria;

END;

$function$
