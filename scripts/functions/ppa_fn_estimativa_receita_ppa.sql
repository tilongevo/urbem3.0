CREATE OR REPLACE FUNCTION ppa.fn_estimativa_receita_ppa(incodppa integer)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $function$
DECLARE
    reRegistro RECORD;
    boRetorno  BOOLEAN;
    stSql      VARCHAR := '';
BEGIN

    stSql := '
	    SELECT *
	    FROM (
			SELECT CAST(1 AS INTEGER) AS cod_receita
			     , CAST(''RECEITAS CORRENTES'' AS CHARACTER VARYING(80)) AS descricao
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_1
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_2
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_3
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_4
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano1_ano_4
			  FROM ppa.estimativa_orcamentaria_base
         LEFT JOIN ppa.ppa_estimativa_orcamentaria_base
                ON ppa_estimativa_orcamentaria_base.cod_receita = estimativa_orcamentaria_base.cod_receita
               AND ppa_estimativa_orcamentaria_base.cod_ppa = '||inCodPPA||'
             WHERE estimativa_orcamentaria_base.tipo = ''A''
               AND ppa_estimativa_orcamentaria_base.cod_receita < 19



			UNION ALL

			SELECT CAST(2 AS INTEGER) AS cod_receita
			     , CAST(''RECEITAS TRIBUTÁRIA'' AS CHARACTER VARYING(80)) AS descricao
			     , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_1
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_2
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_3
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_4
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano1_ano_4
			  FROM ppa.estimativa_orcamentaria_base
         LEFT JOIN ppa.ppa_estimativa_orcamentaria_base
                ON ppa_estimativa_orcamentaria_base.cod_receita = estimativa_orcamentaria_base.cod_receita
               AND ppa_estimativa_orcamentaria_base.cod_ppa = '||inCodPPA||'
             WHERE estimativa_orcamentaria_base.tipo = ''A''
               AND ppa_estimativa_orcamentaria_base.cod_receita < 12


			UNION ALL

			SELECT CAST(3 AS INTEGER) AS cod_receita
			     , CAST(''IMPOSTOS'' AS CHARACTER VARYING(80)) AS descricao
			     , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_1
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_2
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_3
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_4
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano1_ano_4
			  FROM ppa.estimativa_orcamentaria_base
         LEFT JOIN ppa.ppa_estimativa_orcamentaria_base
                ON ppa_estimativa_orcamentaria_base.cod_receita = estimativa_orcamentaria_base.cod_receita
               AND ppa_estimativa_orcamentaria_base.cod_ppa = '||inCodPPA||'
             WHERE estimativa_orcamentaria_base.tipo = ''A''
               AND estimativa_orcamentaria_base.cod_receita BETWEEN 4 AND 9


			UNION ALL

			SELECT CAST(4 AS INTEGER) AS cod_receita
			     , CAST(''Impostos sobre o Patrimônio e a Renda'' AS CHARACTER VARYING(80)) AS descricao
			     , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_1
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_2
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_3
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_4
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano1_ano_4
			  FROM ppa.estimativa_orcamentaria_base
         LEFT JOIN ppa.ppa_estimativa_orcamentaria_base
                ON ppa_estimativa_orcamentaria_base.cod_receita = estimativa_orcamentaria_base.cod_receita
               AND ppa_estimativa_orcamentaria_base.cod_ppa = '||inCodPPA||'
             WHERE estimativa_orcamentaria_base.tipo = ''A''
               AND estimativa_orcamentaria_base.cod_receita BETWEEN 5 AND 7


			UNION ALL

			SELECT CAST(8 AS INTEGER) AS cod_receita
			     , CAST(''Imposto sobre a Produção e a Circulação'' AS CHARACTER VARYING(80)) AS descricao
			     , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_1
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_2
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_3
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_4
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00)
                      + COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00)
                      + COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00)
                      + COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano1_ano_4
              FROM ppa.estimativa_orcamentaria_base
         LEFT JOIN ppa.ppa_estimativa_orcamentaria_base
                ON ppa_estimativa_orcamentaria_base.cod_receita = estimativa_orcamentaria_base.cod_receita
               AND ppa_estimativa_orcamentaria_base.cod_ppa = '||inCodPPA||'
             WHERE estimativa_orcamentaria_base.tipo = ''A''
               AND ppa_estimativa_orcamentaria_base.cod_receita = 9

			UNION ALL

			SELECT CAST(19 AS INTEGER) AS cod_receita
			     , CAST(''RECEITAS DE CAPITAL'' AS CHARACTER VARYING(80)) AS descricao
			     , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_1
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_2
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_3
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_4
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano1_ano_4
			  FROM ppa.estimativa_orcamentaria_base
         LEFT JOIN ppa.ppa_estimativa_orcamentaria_base
                ON ppa_estimativa_orcamentaria_base.cod_receita = estimativa_orcamentaria_base.cod_receita
               AND ppa_estimativa_orcamentaria_base.cod_ppa = '||inCodPPA||'
             WHERE estimativa_orcamentaria_base.tipo = ''A''
               AND ppa_estimativa_orcamentaria_base.cod_receita BETWEEN 20 AND 24

			UNION ALL

			SELECT CAST(26 AS INTEGER) AS cod_receita
			     , CAST(''TOTAL DAS RECEITAS'' AS CHARACTER VARYING(80)) AS descricao
			     , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_1
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_2
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_3
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_4
                 , CAST(TO_CHAR(COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00)
                              + COALESCE(SUM(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor), 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano1_ano_4
			  FROM ppa.estimativa_orcamentaria_base
         LEFT JOIN ppa.ppa_estimativa_orcamentaria_base
                ON ppa_estimativa_orcamentaria_base.cod_receita = estimativa_orcamentaria_base.cod_receita
               AND ppa_estimativa_orcamentaria_base.cod_ppa = '||inCodPPA||'
             WHERE estimativa_orcamentaria_base.tipo = ''A''

			UNION ALL

            SELECT estimativa_orcamentaria_base.cod_receita
                 , estimativa_orcamentaria_base.descricao
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_1
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_2
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_3
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano_4
                 , CAST(TO_CHAR(COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_1)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00)
                      + COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_2)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00)
                      + COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_3)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00)
                      + COALESCE(((ppa_estimativa_orcamentaria_base.valor * ppa_estimativa_orcamentaria_base.percentual_ano_4)/100) + ppa_estimativa_orcamentaria_base.valor, 0.00), ''FM999999999990.00'') AS numeric(14,2)) AS ano1_ano_4
              FROM ppa.estimativa_orcamentaria_base
         LEFT JOIN ppa.ppa_estimativa_orcamentaria_base
                ON ppa_estimativa_orcamentaria_base.cod_receita = estimativa_orcamentaria_base.cod_receita
               AND ppa_estimativa_orcamentaria_base.cod_ppa = '||inCodPPA||'
             WHERE estimativa_orcamentaria_base.tipo = ''A''

	    ) AS tmp
	    ORDER BY tmp.cod_receita;
   ';

    FOR reRegistro IN EXECUTE stSql
    LOOP
        RETURN next reRegistro;
    END LOOP;

END;

$function$