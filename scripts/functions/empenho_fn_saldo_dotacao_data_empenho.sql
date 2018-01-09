CREATE OR REPLACE FUNCTION empenho.fn_saldo_dotacao_data_empenho(character varying, integer, character varying, integer, character varying)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$
DECLARE
    stExercicio             ALIAS FOR $1;
    inCodDespesa            ALIAS FOR $2;
    stDataEmpenho           ALIAS FOR $3;
    inEntidade              ALIAS FOR $4;
    stTipoEmissao           ALIAS FOR $5;

    nuTotal                 NUMERIC := 0.00;
    nuValorOriginal         NUMERIC := 0.00;
    nuTotalItens            NUMERIC := 0.00;
    nuValorReserva          NUMERIC := 0.00;
    nuValorReservaManual    NUMERIC := 0.00;
    nuValorAnulado          NUMERIC := 0.00;
    nuValorSuplementado     NUMERIC := 0.00;
    nuValorReduzido         NUMERIC := 0.00;
    dtEmpenho               VARCHAR := '';
    dtInicioExercicio       VARCHAR := '';
BEGIN

    -- stTipoEmissao
    -- 'E' = Empenhos
    -- 'R' = Reservas

    dtInicioExercicio := '01/01/' || stExercicio;

    -- Recupera a data do empenho e seta a data
    SELECT
       CASE WHEN (MAX(dt_empenho) < TO_DATE(dtInicioExercicio,'dd/mm/yyyy')) OR (MAX(dt_empenho) IS NULL)
            THEN dtInicioExercicio
       ELSE
           TO_CHAR(MAX(dt_empenho),'dd/mm/yyyy')
       END AS dataEmpenho
       INTO
           dtEmpenho
       FROM
           empenho.empenho AS e
       LEFT JOIN ( SELECT COALESCE(sum(vl_total),0.00) - COALESCE(sum(vl_anulado),0.00) AS valor
                        , ea.cod_empenho
                        , ea.cod_entidade
                        , ea.exercicio
                     FROM empenho.empenho_anulado AS ea
               INNER JOIN ( SELECT sum(vl_anulado) AS vl_anulado
                                 , ipe.vl_total
                                 , eai.cod_empenho
                                 , eai.cod_entidade
                                 , eai.exercicio
                             FROM empenho.empenho_anulado_item eai
                                  JOIN empenho.item_pre_empenho as ipe
                                  ON (   ipe.exercicio       = eai.exercicio
                                     AND ipe.cod_pre_empenho = eai.cod_pre_empenho
                                     AND ipe.num_item        = eai.num_item
                                  )
                         GROUP BY ipe.vl_total, eai.cod_empenho, eai.cod_entidade, eai.exercicio
                     ) AS itens
                       ON itens.cod_empenho  = ea.cod_empenho
                      AND itens.exercicio    = ea.exercicio
                      AND itens.cod_entidade = ea.cod_entidade
                    WHERE ea.exercicio = stExercicio
                 GROUP BY ea.cod_empenho, ea.cod_entidade, ea.exercicio
               ) AS it
                 ON it.cod_empenho = e.cod_empenho
                AND it.exercicio   = e.exercicio
                AND it.cod_entidade = e.cod_entidade
         WHERE e.cod_empenho IS NOT NULL
           AND (it.valor != 0.00 or it.valor IS NULL)
           AND e.cod_entidade IN (inEntidade)
           AND e.exercicio = stExercicio;

    IF stDataEmpenho <> '' THEN
        dtEmpenho := stDataEmpenho;
    END IF;

    -- Valor Original
    SELECT
        COALESCE(vl_original,0.00)
    INTO
        nuValorOriginal
    FROM
        orcamento.despesa
    WHERE cod_despesa = inCodDespesa
      AND exercicio   = stExercicio;

    IF stTipoEmissao = 'E' THEN

        -- Valor total dos itens, leva me consideração a data final passada como parametro
        SELECT
            COALESCE(sum(vl_total),0.00)
        INTO
            nuTotalItens
        FROM
              empenho.pre_empenho_despesa AS pd
            , empenho.pre_empenho         AS pe
            , empenho.item_pre_empenho    AS it
            , empenho.empenho             AS em
        WHERE pd.cod_pre_empenho  = pe.cod_pre_empenho
          AND pd.exercicio        = pe.exercicio

          AND pe.cod_pre_empenho  = it.cod_pre_empenho
          AND pe.exercicio        = it.exercicio

          AND pe.cod_pre_empenho  = em.cod_pre_empenho
          AND pe.exercicio        = em.exercicio

          AND pd.exercicio        = stExercicio
          AND pd.cod_despesa      = inCodDespesa

          AND em.dt_empenho BETWEEN TO_DATE(dtInicioExercicio,'dd/mm/yyyy')
                                AND TO_DATE(dtEmpenho,'dd/mm/yyyy');

    ELSEIF stTipoEmissao = 'R' THEN

        -- Valor total dos itens, não leva em consideração a data final passada pelo parametro, sendo levado em consideração o periodo todo
        SELECT
            COALESCE(sum(vl_total),0.00)
        INTO
            nuTotalItens
        FROM
              empenho.pre_empenho_despesa AS pd
            , empenho.pre_empenho         AS pe
            , empenho.item_pre_empenho    AS it
            , empenho.empenho             AS em
        WHERE pd.cod_pre_empenho  = pe.cod_pre_empenho
          AND pd.exercicio        = pe.exercicio

          AND pe.cod_pre_empenho  = it.cod_pre_empenho
          AND pe.exercicio        = it.exercicio

          AND pe.cod_pre_empenho  = em.cod_pre_empenho
          AND pe.exercicio        = em.exercicio

          AND pd.exercicio        = stExercicio
          AND pd.cod_despesa      = inCodDespesa;

    END IF;

    IF stTipoEmissao = 'E' THEN

        -- Valor de reserva
        SELECT COALESCE(sum(vl_reserva),0.00)
          INTO
            nuValorReserva
        FROM
            orcamento.reserva_saldos       AS re

     LEFT JOIN orcamento.reserva_saldos_anulada AS rsa
            ON re.cod_reserva  = rsa.cod_reserva
           AND re.exercicio    = rsa.exercicio

         WHERE re.exercicio        = stExercicio
           AND re.cod_despesa      = inCodDespesa
           AND re.dt_validade_final > to_date(now()::text, 'yyyy-mm-dd')
           AND re.dt_inclusao BETWEEN TO_DATE(dtInicioExercicio,'dd/mm/yyyy')
                                  AND TO_DATE(dtEmpenho,'dd/mm/yyyy')
           AND EXTRACT( YEAR FROM re.dt_inclusao)::varchar = stExercicio
           AND rsa.cod_reserva IS NULL;

    ELSEIF stTipoEmissao = 'R' THEN

        -- Valor de reserva levando em consideração todo o período
        SELECT COALESCE(sum(vl_reserva),0.00)
          INTO
            nuValorReserva
        FROM
            orcamento.reserva_saldos       AS re

     LEFT JOIN orcamento.reserva_saldos_anulada AS rsa
            ON re.cod_reserva  = rsa.cod_reserva
           AND re.exercicio    = rsa.exercicio

         WHERE re.exercicio        = stExercicio
           AND re.cod_despesa      = inCodDespesa
           AND re.dt_validade_final > to_date(now()::text, 'yyyy-mm-dd')
           AND EXTRACT( YEAR FROM re.dt_inclusao)::varchar = stExercicio
           AND rsa.cod_reserva IS NULL;

    END IF;

    IF stTipoEmissao = 'E' THEN
        -- Valor Anulado, leva me consideração a data final passada como parametro
        SELECT
             COALESCE(sum(ei.vl_anulado),0.00)
        INTO
             nuValorAnulado
        FROM
             orcamento.despesa              AS de
           , empenho.pre_empenho_despesa    AS pd
           , empenho.pre_empenho            AS pe
           , empenho.item_pre_empenho       AS it
           , empenho.empenho_anulado_item   AS ei
           , empenho.empenho_anulado        AS ea

         WHERE de.cod_despesa      = pd.cod_despesa
           AND de.exercicio        = pd.exercicio

           AND pd.cod_pre_empenho  = pe.cod_pre_empenho
           AND pd.exercicio        = pe.exercicio

           AND pe.cod_pre_empenho  = it.cod_pre_empenho
           AND pe.exercicio        = it.exercicio

           AND it.cod_pre_empenho  = ei.cod_pre_empenho
           AND it.num_item         = ei.num_item
           AND it.exercicio        = ei.exercicio

           AND ei.cod_empenho      = ea.cod_empenho
           AND ei.exercicio        = ea.exercicio
           AND ei.cod_entidade     = ea.cod_entidade
           AND ei.timestamp        = ea.timestamp

           AND de.exercicio        = stExercicio
           AND de.cod_despesa      = inCodDespesa

           AND TO_DATE(to_char(EA.timestamp,'dd/mm/yyyy'),'dd/mm/yyyy') BETWEEN TO_DATE(dtInicioExercicio,'dd/mm/yyyy')
                                                                            AND TO_DATE(dtEmpenho,'dd/mm/yyyy');
    ELSEIF stTipoEmissao = 'R' THEN

        -- Valor Anulado, não leva em consideração a data final passada pelo parametro, sendo levado em consideração o periodo todo
        SELECT
             COALESCE(sum(ei.vl_anulado),0.00)
        INTO
             nuValorAnulado
        FROM
             orcamento.despesa              AS de
           , empenho.pre_empenho_despesa    AS pd
           , empenho.pre_empenho            AS pe
           , empenho.item_pre_empenho       AS it
           , empenho.empenho_anulado_item   AS ei
           , empenho.empenho_anulado        AS ea

         WHERE de.cod_despesa      = pd.cod_despesa
           AND de.exercicio        = pd.exercicio

           AND pd.cod_pre_empenho  = pe.cod_pre_empenho
           AND pd.exercicio        = pe.exercicio

           AND pe.cod_pre_empenho  = it.cod_pre_empenho
           AND pe.exercicio        = it.exercicio

           AND it.cod_pre_empenho  = ei.cod_pre_empenho
           AND it.num_item         = ei.num_item
           AND it.exercicio        = ei.exercicio

           AND ei.cod_empenho      = ea.cod_empenho
           AND ei.exercicio        = ea.exercicio
           AND ei.cod_entidade     = ea.cod_entidade
           AND ei.timestamp        = ea.timestamp

           AND de.exercicio        = stExercicio
           AND de.cod_despesa      = inCodDespesa;

    END IF;

    IF stTipoEmissao = 'E' THEN

        -- Valor suplementado
        SELECT
            COALESCE( sum(valor), 0.00 )
        INTO
            nuValorSuplementado
        FROM
              orcamento.suplementacao_suplementada
            , orcamento.suplementacao  AS S

        WHERE suplementacao_suplementada.cod_suplementacao  = S.cod_suplementacao
          AND suplementacao_suplementada.exercicio          = S.exercicio

          AND suplementacao_suplementada.cod_despesa        = inCodDespesa
          AND suplementacao_suplementada.exercicio          = stExercicio
          AND S.dt_suplementacao BETWEEN TO_DATE(dtInicioExercicio,'dd/mm/yyyy')
                                     AND TO_DATE(dtEmpenho,'dd/mm/yyyy')
          AND NOT EXISTS ( SELECT 1
                             FROM orcamento.suplementacao_anulada osa
                            WHERE cod_suplementacao = S.cod_suplementacao
                              AND osa.exercicio = stExercicio
                        );

    ELSEIF stTipoEmissao = 'R' THEN

        -- Valor suplementado
        SELECT
            COALESCE( sum(valor), 0.00 )
        INTO
            nuValorSuplementado
        FROM
              orcamento.suplementacao_suplementada
            , orcamento.suplementacao  AS S

        WHERE suplementacao_suplementada.cod_suplementacao  = S.cod_suplementacao
          AND suplementacao_suplementada.exercicio          = S.exercicio

          AND suplementacao_suplementada.cod_despesa        = inCodDespesa
          AND suplementacao_suplementada.exercicio          = stExercicio
          AND NOT EXISTS ( SELECT 1
                             FROM orcamento.suplementacao_anulada osa
                            WHERE cod_suplementacao = S.cod_suplementacao
                              AND osa.exercicio = stExercicio
                        );

    END IF;

    IF stTipoEmissao = 'E' THEN

        -- Valor da Suplementação Reduzida
        SELECT
            COALESCE( sum(valor), 0.00 )
        INTO
            nuValorReduzido
        FROM orcamento.suplementacao_reducao

  INNER JOIN orcamento.suplementacao
          ON suplementacao.exercicio = suplementacao_reducao.exercicio
         AND suplementacao.cod_suplementacao = suplementacao_reducao.cod_suplementacao

        WHERE suplementacao_reducao.cod_despesa = inCodDespesa
          AND suplementacao_reducao.exercicio   = stExercicio
          AND suplementacao.dt_suplementacao BETWEEN TO_DATE(dtInicioExercicio,'dd/mm/yyyy')
                                                 AND TO_DATE(dtEmpenho,'dd/mm/yyyy')
          AND cod_tipo <> 16
          AND NOT EXISTS ( SELECT 1
                               FROM orcamento.suplementacao_anulada osa
                              WHERE cod_suplementacao = suplementacao.cod_suplementacao
                                AND osa.exercicio = stExercicio
                    );

    ELSEIF stTipoEmissao = 'R' THEN

        -- Valor da Suplementação Reduzida
        SELECT
            COALESCE( sum(valor), 0.00 )
        INTO
           nuValorReduzido
        FROM orcamento.suplementacao_reducao

  INNER JOIN orcamento.suplementacao
          ON suplementacao.exercicio = suplementacao_reducao.exercicio
         AND suplementacao.cod_suplementacao = suplementacao_reducao.cod_suplementacao

       WHERE suplementacao_reducao.cod_despesa = inCodDespesa
         AND suplementacao_reducao.exercicio   = stExercicio
         AND cod_tipo <> 16
         AND NOT EXISTS ( SELECT 1
                              FROM orcamento.suplementacao_anulada osa
                             WHERE cod_suplementacao = suplementacao.cod_suplementacao
                               AND osa.exercicio = stExercicio
                   );

    END IF;

    IF( nuValorReserva IS NULL ) THEN
        nuValorReserva := 0.00;
    END IF;

    RETURN (nuValorOriginal - nuTotalItens) - nuValorReserva + nuValorAnulado + nuValorSuplementado - nuValorReduzido;

END;
$function$
