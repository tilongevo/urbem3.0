CREATE OR REPLACE FUNCTION ppa.fn_verifica_homologacao(incodppa integer)
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
DECLARE
    reRegistro                  RECORD;
    boRetorno                   BOOLEAN = false;
    stSql                       VARCHAR := '';
    tpTimestampPublicacao       TIMESTAMP;
    tpTimestampMacroObjetivo    TIMESTAMP;
    tpTimestampProgramaSetorial TIMESTAMP;
    tpTimestampPrograma         TIMESTAMP;
    tpTimestampAcao             TIMESTAMP;
BEGIN

    SELECT MAX(timestamp)
      INTO tpTimestampPublicacao
      FROM ppa.ppa_publicacao
     WHERE cod_ppa = inCodPPA;

    IF (tpTimestampPublicacao IS NOT NULL) THEN
        SELECT MAX(macro_objetivo.timestamp)
          INTO tpTimestampMacroObjetivo
          FROM ppa.macro_objetivo
         WHERE macro_objetivo.cod_ppa = inCodPPA;

        SELECT MAX(programa_setorial.timestamp)
          INTO tpTimestampProgramaSetorial
          FROM ppa.macro_objetivo
          JOIN ppa.programa_setorial
            ON programa_setorial.cod_macro = macro_objetivo.cod_macro
         WHERE macro_objetivo.cod_ppa = inCodPPA;

        SELECT MAX(programa.ultimo_timestamp_programa_dados)
          INTO tpTimestampPrograma
          FROM ppa.macro_objetivo
          JOIN ppa.programa_setorial
            ON programa_setorial.cod_macro = macro_objetivo.cod_macro
          JOIN ppa.programa
            ON programa.cod_setorial = programa_setorial.cod_setorial
         WHERE macro_objetivo.cod_ppa = inCodPPA;

        SELECT MAX(acao.ultimo_timestamp_acao_dados)
          INTO tpTimestampAcao
          FROM ppa.macro_objetivo
          JOIN ppa.programa_setorial
            ON programa_setorial.cod_macro = macro_objetivo.cod_macro
          JOIN ppa.programa
            ON programa.cod_setorial = programa_setorial.cod_setorial
          JOIN ppa.acao
            ON acao.cod_programa = programa.cod_programa
         WHERE macro_objetivo.cod_ppa = inCodPPA;

        IF (tpTimestampPublicacao > tpTimestampMacroObjetivo
        AND tpTimestampPublicacao > tpTimestampProgramaSetorial
        AND tpTimestampPublicacao > tpTimestampPrograma
        AND tpTimestampPublicacao > tpTimestampAcao) THEN
            -- o PPA está homologado
            boRetorno = true;
        ELSE
            -- o PPA não está homologado
            boRetorno = false;
        END IF;

    END IF;

    RETURN boRetorno;

END;

$function$
