CREATE OR REPLACE FUNCTION administracao.valor_padrao_desc(integer, integer, integer, character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE
    inCodAtributo       ALIAS FOR $1;
    inCodModulo         ALIAS FOR $2;
    inCodCadastro       ALIAS FOR $3;
    stValores           ALIAS FOR $4;
    stValor             VARCHAR   := '';
    stSaida             VARCHAR   := '';
    reRegistro          RECORD;
    inCount             INTEGER := 1;
    arValores           VARCHAR[] := array[0];

BEGIN
        arValores := string_to_array(trim(stValores),',');

        WHILE true LOOP
            IF arValores[inCount] IS NULL THEN
                EXIT; --Saida do Loop
            END IF;
            SELECT INTO
                    stValor
                    valor_padrao
            FROM    administracao.atributo_valor_padrao
            WHERE   cod_atributo = inCodAtributo AND
                    cod_cadastro = inCodCadastro AND
                    cod_modulo   = inCodModulo   AND
                    cod_valor::VARCHAR    = arValores[inCount];
            stSaida := stSaida || '[][][]' || stValor;
            inCount := inCount + 1;
        END LOOP;
        IF length(stSaida) > 1 THEN
            stSaida := substr(stSaida,7,length(stSaida));
        END IF;

    RETURN stSaida;
END;
$function$
