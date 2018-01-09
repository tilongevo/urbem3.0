CREATE OR REPLACE FUNCTION stn.fn_rel_rgf6_emp_liq_exercicio_recurso_entidade(character varying, character varying, character varying, character varying, character varying)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $function$
DECLARE
    stCodEntidades                  ALIAS FOR $1;
    stExercicio                     ALIAS FOR $2;
    stDataInicial                   ALIAS FOR $3;
    stDataFinal                     ALIAS FOR $4;
    stDataSituacao                  ALIAS FOR $5;

    stSql               VARCHAR   := '';
    reRegistro          RECORD;

BEGIN
    stSql := 'CREATE TEMPORARY TABLE tmp_empenhado AS (
        SELECT
            e.cod_entidade      as entidade,
            e.cod_empenho       as empenho,
            e.exercicio         as exercicio,
            sum(ipe.vl_total)   as valor
        FROM
            empenho.empenho             as e,
            empenho.item_pre_empenho    as ipe,
            empenho.pre_empenho         as pe
            LEFT JOIN empenho.pre_empenho_despesa as ped on(
                pe.exercicio        = ped.exercicio
            AND pe.cod_pre_empenho  = ped.cod_pre_empenho
            )
            LEFT JOIN orcamento.despesa as ode on(
                ped.exercicio       = ode.exercicio
            AND ped.cod_despesa     = ode.cod_despesa
            )

        WHERE
            e.cod_entidade      IN (' || stCodEntidades || ') AND
            e.exercicio         =   ''' || stExercicio || '''::VARCHAR AND

            e.dt_empenho >= to_date(''' || stDataInicial || '''::varchar,''dd/mm/yyyy'') AND

            e.dt_empenho <= to_date(''' || stDataFinal || '''::varchar,''dd/mm/yyyy'') AND

            --Ligação EMPENHO : PRE_EMPENHO
            e.exercicio         = pe.exercicio AND
            e.cod_pre_empenho   = pe.cod_pre_empenho AND

            --Ligação PRE_EMPENHO : ITEM_PRE_EMPENHO
            pe.exercicio        = ipe.exercicio AND
            pe.cod_pre_empenho  = ipe.cod_pre_empenho
        GROUP BY
            e.cod_entidade,
            e.cod_empenho,
            e.exercicio
        )';

        EXECUTE stSql;

   stSql := 'CREATE TEMPORARY TABLE tmp_anulado AS (
        SELECT
            e.cod_entidade      as entidade,
            e.cod_empenho       as empenho,
            e.exercicio         as exercicio,
            sum(eai.vl_anulado) as valor
        FROM
            empenho.empenho                 as e,
            empenho.empenho_anulado         as ea,
            empenho.empenho_anulado_item    as eai,
            empenho.pre_empenho             as pe
            LEFT JOIN empenho.pre_empenho_despesa as ped on(
                pe.exercicio        = ped.exercicio
            AND pe.cod_pre_empenho  = ped.cod_pre_empenho
            )
            LEFT JOIN orcamento.despesa as ode on(
                ped.exercicio       = ode.exercicio
            AND ped.cod_despesa     = ode.cod_despesa
            )

        WHERE
            e.cod_entidade      IN (' || stCodEntidades || ') AND
            e.exercicio         =   ''' || stExercicio || ''' AND ';

        if (stDataInicial is not null and stDataInicial<>'') then
            stSql := stSql || ' e.dt_empenho >= to_date(''' || stDataInicial || '''::varchar,''dd/mm/yyyy'') AND';
        end if;

        if (stDataFinal is not null and stDataFinal<>'') then
            stSql := stSql || ' e.dt_empenho <= to_date(''' || stDataFinal || '''::varchar,''dd/mm/yyyy'') AND';
        end if;

        if (stDataSituacao is not null and stDataSituacao<>'') then
           stSql := stSql || ' to_date( to_char( ea.timestamp, ''dd/mm/yyyy''), ''dd/mm/yyyy'' ) <= to_date (''' || stDataSituacao || '''::varchar,''dd/mm/yyyy'') AND';
        end if;


        stSql := stSql || '
            --Ligação EMPENHO : PRE_EMPENHO
            e.exercicio         = pe.exercicio AND
            e.cod_pre_empenho   = pe.cod_pre_empenho AND

            --Ligação EMPENHO : EMPENHO ANULADO
            e.exercicio        = ea.exercicio AND
            e.cod_entidade     = ea.cod_entidade AND
            e.cod_empenho      = ea.cod_empenho AND

            --Ligação EMPENHO ANULADO : EMPENHO ANULADO ITEM
            ea.exercicio        = eai.exercicio AND
            ea.timestamp        = eai.timestamp AND
            ea.cod_entidade     = eai.cod_entidade AND
            ea.cod_empenho      = eai.cod_empenho
        GROUP BY
            e.cod_entidade,
            e.cod_empenho,
            e.exercicio
        )';

        EXECUTE stSql;

   stSql := 'CREATE TEMPORARY TABLE tmp_liquidado AS (
        SELECT
            e.cod_entidade      as entidade,
            e.cod_empenho       as empenho,
            e.exercicio         as exercicio,
            sum(nli.vl_total)   as valor
        FROM
            empenho.empenho                 as e,
            empenho.nota_liquidacao         as nl,
            empenho.nota_liquidacao_item    as nli,
            empenho.pre_empenho             as pe
            LEFT JOIN empenho.pre_empenho_despesa as ped on(
                pe.exercicio        = ped.exercicio
            AND pe.cod_pre_empenho  = ped.cod_pre_empenho
            )
            LEFT JOIN orcamento.despesa as ode on(
                ped.exercicio       = ode.exercicio
            AND ped.cod_despesa     = ode.cod_despesa
            )
        WHERE
            e.cod_entidade      IN (' || stCodEntidades || ') AND
            e.exercicio         =   ''' || stExercicio || ''' AND ';

        if (stDataInicial is not null and stDataInicial<>'') then
          stSql := stSql || ' e.dt_empenho >= to_date(''' || stDataInicial || '''::varchar,''dd/mm/yyyy'') AND';
        end if;

        if (stDataFinal is not null and stDataFinal<>'') then
          stSql := stSql || ' e.dt_empenho <= to_date(''' || stDataFinal || '''::varchar,''dd/mm/yyyy'') AND';
        end if;

        if (stDataSituacao is not null and stDataSituacao<>'') then
           stSql := stSql || ' nl.dt_liquidacao <= to_date(''' || stDataSituacao || '''::varchar,''dd/mm/yyyy'') AND';
        end if;

        stSql := stSql || '
            --Ligação EMPENHO : PRE_EMPENHO
            e.exercicio         = pe.exercicio AND
            e.cod_pre_empenho   = pe.cod_pre_empenho AND

            --Ligação EMPENHO : NOTA LIQUIDAÇÃO
            e.exercicio         = nl.exercicio_empenho AND
            e.cod_entidade      = nl.cod_entidade AND
            e.cod_empenho       = nl.cod_empenho AND

            --Ligação NOTA LIQUIDAÇÃO : NOTA LIQUIDAÇÃO ITEM
            nl.exercicio        = nli.exercicio AND
            nl.cod_nota         = nli.cod_nota AND
            nl.cod_entidade     = nli.cod_entidade
        GROUP BY
            e.cod_entidade,
            e.cod_empenho,
            e.exercicio
        )';
        EXECUTE stSql;


    stSql := 'CREATE TEMPORARY TABLE tmp_liquidado_anulado AS (
        SELECT
            e.cod_entidade       as entidade,
            e.cod_empenho        as empenho,
            e.exercicio          as exercicio,
            sum(nlia.vl_anulado) as valor
        FROM
            empenho.empenho                 as e,
            empenho.nota_liquidacao         as nl,
            empenho.nota_liquidacao_item    as nli,
            empenho.nota_liquidacao_item_anulado nlia,
            empenho.pre_empenho             as pe
            LEFT JOIN empenho.pre_empenho_despesa as ped on(
                pe.exercicio        = ped.exercicio
            AND pe.cod_pre_empenho  = ped.cod_pre_empenho
            )
            LEFT JOIN orcamento.despesa as ode on(
                ped.exercicio       = ode.exercicio
            AND ped.cod_despesa     = ode.cod_despesa
            )

        WHERE
            e.cod_entidade      IN (' || stCodEntidades || ') AND
            e.exercicio         =   ''' || stExercicio || ''' AND ';

       if (stDataInicial is not null and stDataInicial<>'') then
          stSql := stSql || ' e.dt_empenho >= to_date(''' || stDataInicial || '''::varchar,''dd/mm/yyyy'') AND';
       end if;

       if (stDataFinal is not null and stDataFinal<>'') then
          stSql := stSql || ' e.dt_empenho <= to_date(''' || stDataFinal || '''::varchar,''dd/mm/yyyy'') AND';
       end if;

        if (stDataSituacao is not null and stDataSituacao<>'') then
           stSql := stSql || ' to_date(to_char(nlia.timestamp,''dd/mm/yyyy''),''dd/mm/yyyy'') <= to_date(''' || stDataSituacao || '''::varchar,''dd/mm/yyyy'') AND';
        end if;

        stSql := stSql || '
            --Ligação EMPENHO : PRE_EMPENHO
            e.exercicio         = pe.exercicio AND
            e.cod_pre_empenho   = pe.cod_pre_empenho AND

            --Ligação EMPENHO : NOTA LIQUIDAÇÃO
            e.exercicio         = nl.exercicio_empenho AND
            e.cod_entidade      = nl.cod_entidade AND
            e.cod_empenho       = nl.cod_empenho AND

            --Ligação NOTA LIQUIDAÇÃO : NOTA LIQUIDAÇÃO ITEM
            nl.exercicio        = nli.exercicio AND
            nl.cod_nota         = nli.cod_nota AND
            nl.cod_entidade     = nli.cod_entidade AND

            --Ligação NOTA LIQUIDAÇÃO ITEM : NOTA LIQUIDAÇÃO ITEM ANULADO
            nli.exercicio       = nlia.exercicio AND
            nli.cod_nota        = nlia.cod_nota AND
            nli.cod_entidade    = nlia.cod_entidade AND
            nli.num_item        = nlia.num_item AND
            nli.cod_pre_empenho = nlia.cod_pre_empenho AND
            nli.exercicio_item  = nlia.exercicio_item
        GROUP BY
            e.cod_entidade,
            e.cod_empenho,
            e.exercicio
        )';
        EXECUTE stSql;

    stSql := 'CREATE TEMPORARY TABLE tmp_pago AS (
        SELECT
            e.cod_entidade      as entidade,
            e.cod_empenho       as empenho,
            e.exercicio         as exercicio,
            sum(nlp.vl_pago)    as valor
        FROM
            empenho.empenho                 as e,
            empenho.nota_liquidacao         as nl,
            empenho.nota_liquidacao_paga    as nlp,
            empenho.pre_empenho             as pe
            LEFT JOIN empenho.pre_empenho_despesa as ped on(
                pe.exercicio        = ped.exercicio
            AND pe.cod_pre_empenho  = ped.cod_pre_empenho
            )
            LEFT JOIN orcamento.despesa as ode on(
                ped.exercicio       = ode.exercicio
            AND ped.cod_despesa     = ode.cod_despesa
            )

        WHERE
            e.cod_entidade      IN (' || stCodEntidades || ') AND
            e.exercicio         =   ''' || stExercicio || ''' AND ';

       if (stDataInicial is not null and stDataInicial<>'') then
          stSql := stSql || ' e.dt_empenho >= to_date(''' || stDataInicial || '''::varchar,''dd/mm/yyyy'') AND';
       end if;

       if (stDataFinal is not null and stDataFinal<>'') then
          stSql := stSql || ' e.dt_empenho <= to_date(''' || stDataFinal || '''::varchar,''dd/mm/yyyy'') AND';
       end if;

        if (stDataSituacao is not null and stDataSituacao<>'') then
           stSql := stSql || ' to_date(to_char(nlp.timestamp,''dd/mm/yyyy''),''dd/mm/yyyy'') <= to_date(''' || stDataSituacao || '''::varchar,''dd/mm/yyyy'') AND';
        end if;


        stSql := stSql || '
             --Ligação EMPENHO : PRE_EMPENHO
            e.exercicio         = pe.exercicio AND
            e.cod_pre_empenho   = pe.cod_pre_empenho AND

            --Ligação EMPENHO : NOTA LIQUIDAÇÃO
            e.exercicio         = nl.exercicio_empenho AND
            e.cod_entidade      = nl.cod_entidade AND
            e.cod_empenho       = nl.cod_empenho AND

            --Ligação NOTA LIQUIDAÇÃO : NOTA LIQUIDAÇÃO PAGA
            nl.exercicio        = nlp.exercicio AND
            nl.cod_nota         = nlp.cod_nota AND
            nl.cod_entidade     = nlp.cod_entidade
        GROUP BY
            e.cod_entidade,
            e.cod_empenho,
            e.exercicio
        )';
        EXECUTE stSql;


    stSql := 'CREATE TEMPORARY TABLE tmp_estornado AS (
        SELECT
            e.cod_entidade          as entidade,
            e.cod_empenho           as empenho,
            e.exercicio             as exercicio,
            sum(nlpa.vl_anulado)    as valor
        FROM
            empenho.empenho                         as e,
            empenho.nota_liquidacao                 as nl,
            empenho.nota_liquidacao_paga            as nlp,
            empenho.nota_liquidacao_paga_anulada    as nlpa,
            empenho.pre_empenho             as pe
            LEFT JOIN empenho.pre_empenho_despesa as ped on(
                pe.exercicio        = ped.exercicio
            AND pe.cod_pre_empenho  = ped.cod_pre_empenho
            )
            LEFT JOIN orcamento.despesa as ode on(
                ped.exercicio       = ode.exercicio
            AND ped.cod_despesa     = ode.cod_despesa
            )

        WHERE
            e.cod_entidade          IN (' || stCodEntidades || ') AND
            e.exercicio         =   ''' || stExercicio || ''' AND ';

       if (stDataInicial is not null and stDataInicial<>'') then
          stSql := stSql || ' e.dt_empenho >= to_date(''' || stDataInicial || '''::varchar,''dd/mm/yyyy'') AND';
       end if;

       if (stDataFinal is not null and stDataFinal<>'') then
          stSql := stSql || ' e.dt_empenho <= to_date(''' || stDataFinal || '''::varchar,''dd/mm/yyyy'') AND';
       end if;

        if (stDataSituacao is not null and stDataSituacao<>'') then
           stSql := stSql || ' to_date(to_char(nlpa.timestamp_anulada,''dd/mm/yyyy''),''dd/mm/yyyy'') <= to_date(''' || stDataSituacao || '''::varchar,''dd/mm/yyyy'') AND';
        end if;


        stSql := stSql || '
            --Ligação EMPENHO : PRE_EMPENHO
            e.exercicio         = pe.exercicio AND
            e.cod_pre_empenho   = pe.cod_pre_empenho AND

            --Ligação EMPENHO : NOTA LIQUIDAÇÃO
            e.exercicio             = nl.exercicio_empenho AND
            e.cod_entidade          = nl.cod_entidade AND
            e.cod_empenho           = nl.cod_empenho AND

            --Ligação NOTA LIQUIDAÇÃO : NOTA LIQUIDAÇÃO PAGA
            nl.exercicio            = nlp.exercicio AND
            nl.cod_nota             = nlp.cod_nota AND
            nl.cod_entidade         = nlp.cod_entidade AND

            --Ligação NOTA LIQUIDAÇÃO ITEM : NOTA LIQUIDAÇÃO ITEM ANULADO
            nlp.exercicio           = nlpa.exercicio AND
            nlp.cod_nota            = nlpa.cod_nota AND
            nlp.cod_entidade        = nlpa.cod_entidade AND
            nlp.timestamp           = nlpa.timestamp
        GROUP BY
            e.cod_entidade,
            e.cod_empenho,
            e.exercicio
        )';

        EXECUTE stSql;

stSql := '

SELECT * FROM (
    SELECT
        cod_recurso,
        nom_recurso,
        cod_entidade,
        cast(exercicio AS varchar) as exercicio,
        CAST(cod_plano as varchar)          AS cod_plano_debito,

        ((((sum(coalesce(empenhado,0.00)) - sum(coalesce(anulado,0.00))) - (sum(coalesce(pago,0.00)) - sum(coalesce(estornopago,0.00))))) - ((sum(coalesce(liquidado,0.00)) - sum(coalesce(estornoliquidado,0.00))) -  (sum(coalesce(pago,0.00)) - sum(coalesce(estornopago,0.00))))) as empenhados_nao_liquidados,
        ((sum(coalesce(liquidado,0.00)) - sum(coalesce(estornoliquidado,0.00))) -  (sum(coalesce(pago,0.00)) - sum(coalesce(estornopago,0.00)))) as liquidados_nao_pagos

    FROM (

        SELECT
            ode.cod_recurso,
            ode.nom_recurso,
            e.cod_empenho,
            e.cod_entidade,
            e.exercicio,
            cpa.cod_plano,

            coalesce(empenho.fn_somatorio_razao_credor_empenhado(e.cod_empenho, e.cod_entidade, e.exercicio),0.00) as empenhado,
            coalesce(empenho.fn_somatorio_razao_credor_anulado(e.cod_empenho, e.cod_entidade, e.exercicio),0.00) as anulado,
            coalesce(empenho.fn_somatorio_razao_credor_liquidado(e.cod_empenho, e.cod_entidade, e.exercicio),0.00) as liquidado,
            coalesce(empenho.fn_somatorio_razao_credor_liquidado_anulado(e.cod_empenho, e.cod_entidade, e.exercicio),0.00) as estornoliquidado,
            coalesce(empenho.fn_somatorio_razao_credor_pago(e.cod_empenho, e.cod_entidade, e.exercicio),0.00) as pago,
            coalesce(empenho.fn_somatorio_razao_credor_estornado(e.cod_empenho, e.cod_entidade, e.exercicio),0.00) as estornopago

        FROM empenho.empenho     as e

  INNER JOIN empenho.pre_empenho as pe
          ON e.exercicio       = pe.exercicio
         AND e.cod_pre_empenho = pe.cod_pre_empenho

  INNER JOIN sw_cgm as cgm
          ON pe.cgm_beneficiario = cgm.numcgm

   LEFT JOIN empenho.pre_empenho_despesa as ped
          ON pe.exercicio       = ped.exercicio
         AND pe.cod_pre_empenho = ped.cod_pre_empenho

  LEFT JOIN ( SELECT   despesa.exercicio
                       , despesa.cod_despesa
                       , recurso.cod_recurso
                       , recurso.nom_recurso
                  FROM orcamento.despesa
             LEFT JOIN orcamento.recurso
                    ON recurso.exercicio   = despesa.exercicio
                   AND recurso.cod_recurso = despesa.cod_recurso
            ) as ode
         ON ode.exercicio   = ped.exercicio
        AND ode.cod_despesa = ped.cod_despesa

  LEFT JOIN orcamento.conta_despesa
         ON conta_despesa.exercicio = ped.exercicio
        AND conta_despesa.cod_conta = ped.cod_conta';

    IF stExercicio < '2013' THEN
        stSql := stSql || ' LEFT JOIN contabilidade.plano_conta AS CPC
                                   ON CPC.exercicio = conta_despesa.exercicio
                                  AND CPC.cod_estrutural = ''3.''||conta_despesa.cod_estrutural

                          LEFT JOIN contabilidade.plano_analitica AS CPA
                                 ON CPA.exercicio = CPC.exercicio
                                AND CPA.cod_conta = CPC.cod_conta

                              WHERE';
    ELSE

    stSql := stSql || ' LEFT JOIN contabilidade.plano_conta AS CPC
                               ON CPC.cod_conta = conta_despesa.cod_conta
                              AND CPC.exercicio = conta_despesa.exercicio

                        LEFT JOIN contabilidade.plano_analitica AS CPA
                               ON CPA.exercicio = CPC.exercicio
                              AND CPA.cod_conta = CPC.cod_conta

                           WHERE -- CPA.natureza_saldo <> '''' AND
        ';
    END IF;

        stSql := stSql || '
                e.cod_entidade  IN (' || stCodEntidades || ')
                AND e.exercicio =  ' || quote_Literal(stExercicio) ;

                if (stDataInicial is not null and stDataInicial<>'') then
                   stSql := stSql || ' AND e.dt_empenho >= to_date(''' || stDataInicial || '''::varchar,''dd/mm/yyyy'') ';
                end if;

                if (stDataFinal is not null and stDataFinal<>'') then
                   stSql := stSql || ' AND e.dt_empenho <= to_date(''' || stDataFinal || '''::varchar,''dd/mm/yyyy'') ';
                end if;

        stSql := stSql || '
            GROUP BY
                ode.cod_recurso,
                ode.nom_recurso,
                e.cod_empenho,
                e.cod_entidade,
                e.exercicio,
                cpa.cod_plano
        ) as tbl
        GROUP BY
            cod_recurso,
            nom_recurso,
            cod_entidade,
            exercicio,
            cod_plano
        ) as tmp';

    FOR reRegistro IN EXECUTE stSql
    LOOP
        RETURN next reRegistro;
    END LOOP;

    DROP TABLE tmp_empenhado;
    DROP TABLE tmp_anulado;
    DROP TABLE tmp_liquidado;
    DROP TABLE tmp_liquidado_anulado;
    DROP TABLE tmp_pago;
    DROP TABLE tmp_estornado;

END;
$function$
