CREATE OR REPLACE FUNCTION empenho.fn_saldo_dotacao(character varying, integer)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$

DECLARE
    stExercicio             ALIAS FOR $1;
    inCodDespesa            ALIAS FOR $2;
    nuTotal                 NUMERIC := 0.00;
    nuValorOriginal         NUMERIC := 0.00;
    nuTotalItens            NUMERIC := 0.00;
    nuValorReserva          NUMERIC := 0.00;
    nuValorReservaManual    NUMERIC := 0.00;
    nuValorAnulado          NUMERIC := 0.00;
    nuValorSuplementado     NUMERIC := 0.00;
    nuValorReduzido         NUMERIC := 0.00;

BEGIN
    --VALOR ORIGINAL
    SELECT
        coalesce(vl_original,0.00)
    INTO
        nuValorOriginal
    FROM
        orcamento.despesa
    WHERE
        cod_despesa = inCodDespesa  AND
        exercicio   = stExercicio;


    SELECT
        coalesce(sum(vl_total),0.00)
    INTO
        nuTotalItens
    FROM
        empenho.pre_empenho_despesa as pd,
        empenho.pre_empenho         as pe,
        empenho.item_pre_empenho    as it,
        empenho.empenho             as em
    WHERE
        pd.cod_pre_empenho  = pe.cod_pre_empenho    AND
        pd.exercicio        = pe.exercicio          AND

        pe.cod_pre_empenho  = it.cod_pre_empenho    AND
        pe.exercicio        = it.exercicio          AND

        pe.cod_pre_empenho  = em.cod_pre_empenho    AND
        pe.exercicio        = em.exercicio          AND

        pd.exercicio        = stExercicio           AND
        pd.cod_despesa      = inCodDespesa
    ;


--
--      FOI INCLUÍDO ESSE CASE DEVIDO AO FATO DO SISTEMA, INDEPENDENTEMENTE DA DATA DE VALIDADE FINAL,
--      ESTAVA CONSIDERANDO SEMPRE O VALOR DA RESERVA.

    SELECT
   --     case when re.dt_validade_final > to_date(now(), 'yyyy-mm-dd') then
            coalesce(sum(vl_reserva),0.00)
   --     else
   --         0.00
   --     end
    INTO
        nuValorReserva
    FROM
        --  Comentamos a parte abaixo para que a PL leve em consideração as reservas de saldo feitas
        --  na homologação da solicitação (GP compras).

--      orcamento.despesa              as de,
--      empenho.pre_empenho_despesa    as pd,
--      empenho.pre_empenho            as pe,
--      empenho.autorizacao_empenho    as ae,
--      empenho.autorizacao_reserva    as ar,
        orcamento.reserva_saldos       as re
            LEFT JOIN orcamento.reserva_saldos_anulada as rsa ON
                re.cod_reserva  = rsa.cod_reserva AND
                re.exercicio    = rsa.exercicio
    WHERE
--      de.cod_despesa      = pd.cod_despesa        AND
--      de.exercicio        = pd.exercicio          AND
--
--      pd.cod_pre_empenho  = pe.cod_pre_empenho    AND
--      pd.exercicio        = pe.exercicio          AND
--
--      pe.cod_pre_empenho  = ae.cod_pre_empenho    AND
--      pe.exercicio        = ae.exercicio          AND
--
--      ae.cod_autorizacao  = ar.cod_autorizacao    AND
--      ae.exercicio        = ar.exercicio          AND
--      ae.cod_entidade     = ar.cod_entidade       AND
--
--      ar.exercicio        = re.exercicio          AND
--      ar.cod_reserva      = re.cod_reserva        AND
--
--      de.exercicio        = stExercicio           AND
--      de.cod_despesa      = inCodDespesa          AND

		re.exercicio        = stExercicio           AND
        re.cod_despesa      = inCodDespesa          AND
        re.dt_validade_final > to_date(now()::text, 'yyyy-mm-dd') AND
        EXTRACT( YEAR FROM re.dt_inclusao)::varchar = stExercicio AND
        rsa.cod_reserva     is null;
--    GROUP BY
--        re.dt_validade_final;


--
--  Desconsiderado o trecho abaixo porque o trecho acima ja considera as reservas manuais.
--
-- SELECT
--     coalesce(sum(rs.vl_reserva),0.00)
-- INTO
--     nuValorReservaManual
-- FROM
--     orcamento.reserva_saldos            as rs
--         LEFT JOIN orcamento.reserva_saldos_anulada as rsa ON
--             rs.cod_reserva  = rsa.cod_reserva AND
--             rs.exercicio    = rsa.exercicio
-- WHERE
--     rs.exercicio        = stExercicio           AND
--     rs.cod_despesa      = inCodDespesa          AND
--      rs.tipo             = 'M'                  AND
--     rsa.cod_reserva     is null;


   SELECT
        coalesce(sum(ei.vl_anulado),0.00)
   INTO
        nuValorAnulado
   FROM
        orcamento.despesa              as de,
        empenho.pre_empenho_despesa    as pd,
        empenho.pre_empenho            as pe,
        empenho.item_pre_empenho       as it,
        empenho.empenho_anulado_item   as ei,
        empenho.empenho_anulado        as ea
    WHERE
        de.cod_despesa      = pd.cod_despesa        AND
        de.exercicio        = pd.exercicio          AND

        pd.cod_pre_empenho  = pe.cod_pre_empenho    AND
        pd.exercicio        = pe.exercicio          AND

        pe.cod_pre_empenho  = it.cod_pre_empenho    AND
        pe.exercicio        = it.exercicio          AND

        it.cod_pre_empenho  = ei.cod_pre_empenho    AND
        it.num_item         = ei.num_item           AND
        it.exercicio        = ei.exercicio          AND

        ei.cod_empenho      = ea.cod_empenho        AND
        ei.exercicio        = ea.exercicio          AND
        ei.cod_entidade     = ea.cod_entidade       AND
        ei.timestamp        = ea.timestamp          AND

        de.exercicio        = stExercicio           AND
        de.cod_despesa      = inCodDespesa;

    SELECT
        coalesce( sum(valor), 0.00 )
    INTO
        nuValorSuplementado
    FROM
        orcamento.suplementacao_suplementada
    WHERE
        cod_despesa = inCodDespesa  AND
        exercicio = stExercicio;

    SELECT
        coalesce( sum(valor), 0.00 )
    INTO
        nuValorReduzido
    FROM
        orcamento.suplementacao_reducao
    WHERE
        cod_despesa = inCodDespesa  AND
        exercicio   = stExercicio;


    if( nuValorReserva IS NULL ) then
        nuValorReserva := 0.00;
    end if;

    RETURN nuValorOriginal - nuTotalItens - nuValorReserva + nuValorAnulado + nuValorSuplementado - nuValorReduzido;

END;
$function$
