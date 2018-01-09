CREATE OR REPLACE FUNCTION empenho.retorna_notas_empenhos(character varying, integer, integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE
    stExercicio         ALIAS FOR $1;
    inCodOrdem          ALIAS FOR $2;
    inCodEntidade       ALIAS FOR $3;
    stSaida             VARCHAR   := '';
    stSql               VARCHAR   := '';
    reRegistro          RECORD;
BEGIN
    stSql := '
                SELECT
                         pl.cod_nota
                        ,pl.exercicio_liquidacao
                        ,nl.cod_empenho
                        ,nl.exercicio_empenho
                FROM
                        empenho.pagamento_liquidacao    as pl
                       ,empenho.nota_liquidacao         as nl
                WHERE
                        pl.exercicio_liquidacao = nl.exercicio
                AND     pl.cod_nota             = nl.cod_nota
                AND     pl.cod_entidade         = nl.cod_entidade
                AND     pl.exercicio            = ''' || stExercicio     || '''
                AND     pl.cod_ordem            = ' || inCodOrdem      || '
                AND     pl.cod_entidade         = ' || inCodEntidade   || '
            ';
    FOR reRegistro IN EXECUTE stSql
    LOOP
        stSaida := stSaida || reRegistro.cod_nota || '/' || reRegistro.exercicio_liquidacao || '   ';
        stSaida := stSaida || reRegistro.cod_empenho || '/'|| reRegistro.exercicio_empenho  || '
 ';
    END LOOP;

    RETURN stSaida;
END;
$function$

