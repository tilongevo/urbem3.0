CREATE OR REPLACE FUNCTION ldo.fn_verifica_homologacao_ldo(incodppa integer, stano character)
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
DECLARE
    boExist         BOOLEAN := FALSE;
    tpHomologacao   TIMESTAMP;
    tpLDO           TIMESTAMP;

BEGIN

    SELECT MAX(timestamp)
      INTO tpHomologacao
      FROM ldo.homologacao
     WHERE cod_ppa = inCodPPA
       AND ano     = stAno;

    IF(tpHomologacao IS NOT NULL)
    THEN

        SELECT timestamp
          INTO tpLDO
          FROM ldo.ldo
         WHERE cod_ppa = inCodPPA
           AND ano     = stAno;

        IF (tpLDO < tpHomologacao)
        THEN
            boExist := TRUE;
        END IF;

    END IF;

    RETURN boExist;

END;

$function$
