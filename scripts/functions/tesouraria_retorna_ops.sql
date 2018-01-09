CREATE OR REPLACE FUNCTION tesouraria.retorna_ops(character varying, integer, integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE
    stExercicio         ALIAS FOR $1;
    inCodBordero        ALIAS FOR $2;
    inCodEntidade       ALIAS FOR $3;
    stSaida             VARCHAR   := '';
    stSql               VARCHAR   := '';
    reRegistro          RECORD;
BEGIN
    stSql := '
                SELECT
                         tp.cod_ordem
                        ,tp.exercicio
                FROM
                        tesouraria.transacoes_pagamento    as tp
                WHERE
                        tp.exercicio            = ''' || stExercicio     || '''
                AND     tp.cod_bordero          = ' || inCodBordero    || '
                AND     tp.cod_entidade         = ' || inCodEntidade   || '
            ';
    FOR reRegistro IN EXECUTE stSql
    LOOP
        stSaida := stSaida || reRegistro.cod_ordem || '/';
    END LOOP;

    stSaida := substr(stSaida,0,length(stSaida));

    RETURN stSaida;
END;
$function$
