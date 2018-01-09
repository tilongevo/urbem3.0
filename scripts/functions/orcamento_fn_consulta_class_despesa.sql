CREATE OR REPLACE FUNCTION orcamento.fn_consulta_class_despesa(integer, character varying, character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$

    DECLARE
        r_record          RECORD;

        v_codigo          VARCHAR;
        v_sql             VARCHAR;
        v_exercicio       VARCHAR;
        v_mascara         VARCHAR;

        i_codclass        INTEGER;
        i_codconta        INTEGER;

    BEGIN
        v_codigo = '';
        v_mascara = $3;

        IF '||TRIM($1::text)||' <> '0' THEN

            v_exercicio := $2;
            i_codconta  := $1;

            v_sql := '
                SELECT
                    cd.cod_classificacao, cd.cod_conta
                FROM
                    orcamento.classificacao_despesa cd
                WHERE
                    cd.cod_conta  = '||i_codconta||' AND
                    cd.exercicio  = '''||v_exercicio||'''
		ORDER BY
		    cd.cod_posicao
                ';

            FOR r_record IN EXECUTE v_sql LOOP
                v_codigo := v_codigo||'.'||r_record.cod_classificacao;
            END LOOP;

        END IF;

        v_codigo := SUBSTR(v_codigo,2,LENGTH(v_codigo));
        v_codigo := sw_fn_mascara_dinamica(v_mascara , v_codigo);

        RETURN v_codigo;

    END;

$function$
