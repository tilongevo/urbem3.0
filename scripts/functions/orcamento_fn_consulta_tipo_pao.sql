CREATE OR REPLACE FUNCTION orcamento.fn_consulta_tipo_pao(character varying, integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
DECLARE
    stExercicio                 ALIAS FOR $1;
    inNumPao                    ALIAS FOR $2;
    stSql                       VARCHAR   := '';

    inPosPao                    INTEGER;
    inMascPao                   INTEGER;
    inTipoPao                   INTEGER;

    arRetorno                   NUMERIC[] := array[0];
    crCursor                    REFCURSOR;
BEGIN

    SELECT
        string_to_array(valor,'.') INTO arRetorno
    FROM
        administracao.configuracao
    WHERE
        parametro   = 'masc_despesa' AND
        exercicio   = stExercicio  AND
        cod_modulo  = 8 ;

    IF(arRetorno IS NULL) THEN
        RETURN NULL;
    END IF;

    SELECT
        valor INTO inPosPao
    FROM
        administracao.configuracao
    WHERE
        parametro   = 'pao_posicao_digito_id' AND
        exercicio   = stExercicio  AND
        cod_modulo  = 8 ;

    SELECT substr(publico.fn_mascara_dinamica(cast(arRetorno[5]as varchar), cast(inNumPao as varchar) ),inPosPao,1) INTO inMascPao ;

    SELECT
        strpos(valor,cast(inMascPao as varchar)) INTO inPosPao
    FROM
        administracao.configuracao
    WHERE
        parametro   = 'pao_digitos_id_projeto' AND
        exercicio   = stExercicio  AND
        cod_modulo  = 8 ;

    IF (inPosPao<=0) THEN
        SELECT
            strpos(valor,cast(inMascPao as varchar)) INTO inPosPao
        FROM
            administracao.configuracao
        WHERE
            parametro   = 'pao_digitos_id_atividade' AND
            exercicio   = stExercicio  AND
            cod_modulo  = 8 ;
        IF (inPosPao<=0) THEN
            SELECT
                strpos(valor,cast(inMascPao as varchar)) INTO inPosPao
            FROM
                administracao.configuracao
            WHERE
                parametro   = 'pao_digitos_id_oper_especiais' AND
                exercicio   = stExercicio  AND
                cod_modulo  = 8 ;
            IF (inPosPao <= 0) THEN
                SELECT
                    strpos(valor,cast(inMascPao as varchar)) INTO inPosPao
                FROM
                    administracao.configuracao
                WHERE
                    parametro   = 'pao_digitos_id_nao_orcamentarios' AND
                    exercicio   = stExercicio  AND
                    cod_modulo  = 8 ;
                IF (inPosPao > 0) THEN
                    inTipoPao := 4;
                END IF;
            ELSE
                inTipoPao := 3;
            END IF;
        ELSE
            inTipoPao := 2;
        END IF;
    ELSE
        inTipoPao := 1;
    END IF;


    RETURN inTipoPao;
END;
$function$