CREATE OR REPLACE FUNCTION contabilidade.fn_saldo_inicial_conta_analitica_entidade_rp(character varying, integer, integer)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$
DECLARE
    stExercicio    ALIAS FOR $1;
    inCodPlano     ALIAS FOR $2;
    inCodEntidade  ALIAS FOR $3;
    stSql          VARCHAR := '';
    nuVlDebito     NUMERIC := 0.00;
    nuVlCredito    NUMERIC := 0.00;
    reRecord       RECORD;

BEGIN
    -------------------------------
    ---- CONSULTA VALOR DEBITO ----
    -------------------------------
          SELECT COALESCE(SUM(vl_lancamento ), 0.00 ) INTO nuVlDebito
            FROM contabilidade.plano_analitica  AS CPA
              -- Join com conta_debito
      INNER JOIN contabilidade.conta_debito     AS CCD
              ON CPA.exercicio    = CCD.exercicio
             AND CPA.cod_plano    = CCD.cod_plano
              -- Join com valor_lacamento
      INNER JOIN contabilidade.valor_lancamento AS CVL
              ON CCD.exercicio    = CVL.exercicio
             AND CCD.cod_entidade = CVL.cod_entidade
             AND CCD.tipo         = CVL.tipo
             AND CCD.tipo_valor   = CVL.tipo_valor
             AND CCD.cod_lote     = CVL.cod_lote
             AND CCD.sequencia    = CVL.sequencia
              -- Join com lacamento
      INNER JOIN contabilidade.lancamento AS CL
              ON CVL.exercicio    = CL.exercicio
             AND CVL.cod_entidade = CL.cod_entidade
             AND CVL.tipo         = CL.tipo
             AND CVL.cod_lote     = CL.cod_lote
             AND CVL.sequencia    = CL.sequencia
              -- Join com lote
      INNER JOIN contabilidade.lote
              ON CL.exercicio    = lote.exercicio
             AND CL.cod_entidade = lote.cod_entidade
             AND CL.tipo         = lote.tipo
             AND CL.cod_lote     = lote.cod_lote
              -- Filtros
           WHERE CPA.exercicio    = stExercicio
             AND CPA.cod_plano    = inCodPlano
             AND CVL.cod_entidade = inCodEntidade
             AND lote.dt_lote = TO_DATE('01/01/'||stExercicio,'dd/mm/yyyy');
    --------------------------------
    ---- CONSULTA VALOR cREDITO ----
    --------------------------------
          SELECT coalesce(sum( vl_lancamento ), 0.00 ) INTO nuVlCredito
            FROM contabilidade.plano_analitica  AS CPA
              -- Join com conta_debito
      INNER JOIN contabilidade.conta_credito    AS CCC
              ON CPA.exercicio    = CCC.exercicio
             AND CPA.cod_plano    = CCC.cod_plano
              -- Join com valor_lacamento
      INNER JOIN contabilidade.valor_lancamento AS CVL
              ON CCC.exercicio    = CVL.exercicio
             AND CCC.cod_entidade = CVL.cod_entidade
             AND CCC.tipo         = CVL.tipo
             AND CCC.tipo_valor   = CVL.tipo_valor
             AND CCC.cod_lote     = CVL.cod_lote
             AND CCC.sequencia    = CVL.sequencia
              -- Join com lacamento
      INNER JOIN contabilidade.lancamento AS CL
              ON CVL.exercicio    = CL.exercicio
             AND CVL.cod_entidade = CL.cod_entidade
             AND CVL.tipo         = CL.tipo
             AND CVL.cod_lote     = CL.cod_lote
             AND CVL.sequencia    = CL.sequencia
              -- Join com lote
      INNER JOIN contabilidade.lote
              ON CL.exercicio    = lote.exercicio
             AND CL.cod_entidade = lote.cod_entidade
             AND CL.tipo         = lote.tipo
             AND CL.cod_lote     = lote.cod_lote
              -- Filtros
           WHERE CPA.exercicio    = stExercicio
             AND CPA.cod_plano    = inCodPlano
             AND CVL.cod_entidade = inCodEntidade
             AND lote.dt_lote = TO_DATE('01/01/'||stExercicio,'dd/mm/yyyy');

    RETURN nuVlDebito + nuVlCredito;

END;
$function$