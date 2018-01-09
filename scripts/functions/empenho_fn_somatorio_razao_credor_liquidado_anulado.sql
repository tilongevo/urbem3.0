CREATE OR REPLACE FUNCTION empenho.fn_somatorio_razao_credor_liquidado_anulado(integer, integer, character varying)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$
DECLARE
    inEmpenho                   ALIAS FOR $1;
    inEntidade                  ALIAS FOR $2;
    stExercicio                 ALIAS FOR $3;
    stSql                       VARCHAR   := '';
    nuSoma                      NUMERIC   := 0;
    crCursor                    REFCURSOR;

BEGIN
     stSql := '
        SELECT   coalesce(sum(valor),0.00)
        FROM
                 tmp_liquidado_anulado
        WHERE
                empenho   =  ' || quote_literal(inEmpenho) || ' AND
                entidade  =  ' || quote_literal(inEntidade) || ' AND
                exercicio =  ' || quote_literal(stExercicio);

    OPEN crCursor FOR EXECUTE stSql;
    FETCH crCursor INTO nuSoma;
    CLOSE crCursor;

    RETURN nuSoma;
END;
$function$
