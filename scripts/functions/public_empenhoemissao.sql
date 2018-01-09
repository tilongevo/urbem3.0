CREATE OR REPLACE FUNCTION public.empenhoemissao(character varying, numeric, character varying, integer, character varying, integer, integer, integer, character varying)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
DECLARE
        EXERCICIO ALIAS FOR $1;
        VALOR ALIAS FOR $2;
        COMPLEMENTO ALIAS FOR $3;
        CODLOTE ALIAS FOR $4;
        TIPOLOTE ALIAS FOR $5;
        CODENTIDADE ALIAS FOR $6;
        CODPREEMPENHO ALIAS FOR $7;
        CODDESPESA ALIAS FOR $8;
        CODCLASSDESPESA ALIAS FOR $9;

        SEQUENCIA INTEGER;
        SQLCONFIGURACAO VARCHAR := '';
        SQLVINCULORECURSO VARCHAR := '';
        SQLVALIDAESTRUTURALCONTADESPESA VARCHAR := '';
        SQLCONTAFIXA VARCHAR := '';
        STCODESTRUTURALVINCULOCREDITO VARCHAR := '';
        STCODESTRUTURALVINCULODEBITO VARCHAR := '';
        INCODCONTAVINCULOCREDITO INTEGER := NULL;
        INCODCONTAVINCULODEBITO INTEGER := NULL;
        REREGISTROSCONFIGURACAO RECORD;
        REREGISTROSRECURSO RECORD;
        REREGISTROSVALIDAESTRUTURALCONTADESPESA RECORD;
        REREGISTROSCONTAFIXA RECORD;
        INCONTCONFIGURACAO INTEGER := 0;
        INCONTVINCULO INTEGER := 0;
        INCONTVALIDAESTRUTURALCONTADESPESA INTEGER := 0;

BEGIN

        SQLCONTAFIXA := '
                SELECT debito.cod_estrutural AS estrutural_debito
                     , credito.cod_estrutural AS estrutural_credito
                     , debito.cod_plano AS plano_debito
                     , credito.cod_plano AS plano_credito
                     , debito.exercicio
                  FROM (
                         SELECT plano_conta.cod_estrutural
                              , plano_analitica.cod_plano
                              , plano_conta.exercicio
                           FROM contabilidade.plano_conta
                     INNER JOIN contabilidade.plano_analitica
                             ON plano_conta.cod_conta = plano_analitica.cod_conta
                            AND plano_conta.exercicio = plano_analitica.exercicio
                          WHERE REPLACE(plano_conta.cod_estrutural, ''.'', '''') LIKE ''622110000%''
                       ) AS debito
            INNER JOIN (
                         SELECT plano_conta.cod_estrutural
                              , plano_analitica.cod_plano
                              , plano_conta.exercicio
                           FROM contabilidade.plano_conta
                     INNER JOIN contabilidade.plano_analitica
                             ON plano_conta.cod_conta = plano_analitica.cod_conta
                            AND plano_conta.exercicio = plano_analitica.exercicio
                          WHERE REPLACE(plano_conta.cod_estrutural, ''.'', '''') LIKE ''622130100%''
                       ) AS credito
                     ON debito.exercicio = credito.exercicio
                  WHERE debito.exercicio = '''||EXERCICIO||'''
        ';
        --raise notice '%', SQLCONTAFIXA;

        FOR REREGISTROSCONTAFIXA IN EXECUTE SQLCONTAFIXA
        LOOP
                SEQUENCIA := FAZERLANCAMENTO(  REREGISTROSCONTAFIXA.estrutural_debito , REREGISTROSCONTAFIXA.estrutural_credito , 901 , EXERCICIO , VALOR , COMPLEMENTO , CODLOTE , TIPOLOTE , CODENTIDADE , REREGISTROSCONTAFIXA.plano_debito, REREGISTROSCONTAFIXA.plano_credito );
        END LOOP;

        SQLVINCULORECURSO := '
                  SELECT tabela.conta_debito
                       , tabela.conta_credito
                       , tabela.cod_plano
                    FROM (
                            SELECT CASE WHEN plano_conta.cod_estrutural like ''8.2.1.1.1%'' THEN
                                        plano_conta.cod_estrutural
                                   ELSE
                                        NULL
                                   END AS conta_debito
                                 , CASE WHEN plano_conta.cod_estrutural like ''8.2.1.1.2%'' THEN
                                        plano_conta.cod_estrutural
                                   ELSE
                                        NULL
                                   END AS conta_credito
                                 , plano_analitica.cod_plano AS cod_plano
                              FROM contabilidade.plano_conta
                        INNER JOIN contabilidade.plano_analitica
                                ON plano_conta.cod_conta = plano_analitica.cod_conta
                               AND plano_conta.exercicio = plano_analitica.exercicio
                        INNER JOIN contabilidade.plano_recurso
                                ON plano_analitica.cod_plano = plano_recurso.cod_plano
                               AND plano_analitica.exercicio = plano_recurso.exercicio
                        INNER JOIN orcamento.recurso
                                ON plano_recurso.cod_recurso = recurso.cod_recurso
                               AND plano_recurso.exercicio = recurso.exercicio
                        INNER JOIN orcamento.despesa
                                ON recurso.cod_recurso = despesa.cod_recurso
                               AND recurso.exercicio = despesa.exercicio
                             WHERE despesa.cod_despesa = '||CODDESPESA::varchar||'
                               AND despesa.exercicio = '''||EXERCICIO||'''
                         ) AS tabela
                   WHERE ( conta_debito IS NOT NULL
                      OR conta_credito IS NOT NULL)
                GROUP BY conta_debito
                       , conta_credito
                       , cod_plano
        ';

        FOR REREGISTROSRECURSO IN EXECUTE SQLVINCULORECURSO
        LOOP
                IF REREGISTROSRECURSO.conta_debito IS NOT NULL THEN
                        STCODESTRUTURALVINCULODEBITO := REREGISTROSRECURSO.conta_debito;
                        INCODCONTAVINCULODEBITO := REREGISTROSRECURSO.cod_plano;
                END IF;

                IF REREGISTROSRECURSO.conta_credito IS NOT NULL THEN
                        STCODESTRUTURALVINCULOCREDITO := REREGISTROSRECURSO.conta_credito;
                        INCODCONTAVINCULOCREDITO := REREGISTROSRECURSO.cod_plano;
                END IF;
                IF STCODESTRUTURALVINCULOCREDITO <> '' AND STCODESTRUTURALVINCULODEBITO <> '' THEN
                        SEQUENCIA := FAZERLANCAMENTO( STCODESTRUTURALVINCULODEBITO , STCODESTRUTURALVINCULOCREDITO , 901 , EXERCICIO , VALOR , COMPLEMENTO , CODLOTE , TIPOLOTE , CODENTIDADE , INCODCONTAVINCULODEBITO, INCODCONTAVINCULOCREDITO );
                        INCONTVINCULO := INCONTVINCULO + 1;
                END IF;
        END LOOP;

        IF INCONTVINCULO = 0 THEN
                RAISE EXCEPTION 'Nenhum recurso vinculado a esta despesa!';
        END IF;

        IF EXERCICIO::INTEGER > 2012 THEN
            SQLCONTAFIXA := '
                    SELECT debito.cod_estrutural AS estrutural_debito
                         , credito.cod_estrutural AS estrutural_credito
                         , debito.cod_plano AS plano_debito
                         , credito.cod_plano AS plano_credito
                         , debito.exercicio
                      FROM (
                             SELECT plano_conta.cod_estrutural
                                  , plano_analitica.cod_plano
                                  , plano_conta.exercicio
                               FROM contabilidade.plano_conta
                         INNER JOIN contabilidade.plano_analitica
                                 ON plano_conta.cod_conta = plano_analitica.cod_conta
                                AND plano_conta.exercicio = plano_analitica.exercicio
                              WHERE REPLACE(plano_conta.cod_estrutural, ''.'',  '''') LIKE ''522920101%''
                           ) AS debito
                INNER JOIN (
                             SELECT plano_conta.cod_estrutural
                                  , plano_analitica.cod_plano
                                  , plano_conta.exercicio
                               FROM contabilidade.plano_conta
                         INNER JOIN contabilidade.plano_analitica
                                 ON plano_conta.cod_conta = plano_analitica.cod_conta
                                AND plano_conta.exercicio = plano_analitica.exercicio
                              WHERE REPLACE(plano_conta.cod_estrutural, ''.'', '''') LIKE ''622920101%''
                           ) AS credito
                         ON debito.exercicio = credito.exercicio
                      WHERE debito.exercicio = '''||EXERCICIO||'''
            ';

            FOR REREGISTROSCONTAFIXA IN EXECUTE SQLCONTAFIXA
            LOOP
                    SEQUENCIA := FAZERLANCAMENTO(  REREGISTROSCONTAFIXA.estrutural_debito , REREGISTROSCONTAFIXA.estrutural_credito , 901 , EXERCICIO , VALOR , COMPLEMENTO , CODLOTE , TIPOLOTE , CODENTIDADE , REREGISTROSCONTAFIXA.plano_debito, REREGISTROSCONTAFIXA.plano_credito );
            END LOOP;

            IF EXERCICIO::INTEGER = 2013 THEN
                SEQUENCIA := EMPENHOEMISSAOMODALIDADESLICITACAO(  EXERCICIO , VALOR , COMPLEMENTO , CODLOTE , TIPOLOTE , CODENTIDADE , CODPREEMPENHO  );

                SQLCONTAFIXA := '
                        SELECT debito.cod_estrutural AS estrutural_debito
                            , credito.cod_estrutural AS estrutural_credito
                            , debito.cod_plano AS plano_debito
                            , credito.cod_plano AS plano_credito
                            , debito.exercicio
                        FROM (
                                SELECT plano_conta.cod_estrutural
                                    , plano_analitica.cod_plano
                                    , plano_conta.exercicio
                                FROM contabilidade.plano_conta
                            INNER JOIN contabilidade.plano_analitica
                                    ON plano_conta.cod_conta = plano_analitica.cod_conta
                                    AND plano_conta.exercicio = plano_analitica.exercicio
                                WHERE REPLACE(plano_conta.cod_estrutural, ''.'', '''') LIKE ''522920901%''
                            ) AS debito
                    INNER JOIN (
                                SELECT plano_conta.cod_estrutural
                                    , plano_analitica.cod_plano
                                    , plano_conta.exercicio
                                FROM contabilidade.plano_conta
                            INNER JOIN contabilidade.plano_analitica
                                    ON plano_conta.cod_conta = plano_analitica.cod_conta
                                    AND plano_conta.exercicio = plano_analitica.exercicio
                                WHERE REPLACE(plano_conta.cod_estrutural, ''.'', '''') LIKE ''622920901%''
                            ) AS credito
                            ON debito.exercicio = credito.exercicio
                        WHERE debito.exercicio = '''||EXERCICIO||'''
                ';

                FOR REREGISTROSCONTAFIXA IN EXECUTE SQLCONTAFIXA
                LOOP
                        SEQUENCIA := FAZERLANCAMENTO(  REREGISTROSCONTAFIXA.estrutural_debito , REREGISTROSCONTAFIXA.estrutural_credito , 901 , EXERCICIO , VALOR , COMPLEMENTO , CODLOTE , TIPOLOTE , CODENTIDADE , REREGISTROSCONTAFIXA.plano_debito, REREGISTROSCONTAFIXA.plano_credito );
                END LOOP;
            END IF;
        END IF;

        RETURN SEQUENCIA;
END;
$function$
