CREATE OR REPLACE FUNCTION contabilidade.fn_abertura_restos_pagar_recurso(character varying, character varying, character varying)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $function$
DECLARE

  stExercicio         ALIAS FOR $1;
  stCodEntidade       ALIAS FOR $2;
  dtFinal             ALIAS FOR $3;

  dtInicial           VARCHAR := '';
  stExercicioAnterior VARCHAR := '';
  stSql               VARCHAR := '';
  reRegistro          RECORD;

BEGIN

  dtInicial := '01/01/' || stExercicio;
  stExercicioAnterior := trim(to_char((to_number(stExercicio,'9999')-1),'9999'));

  -- cria a tabela temporaria para o valor processado no exercicios anteriores
  stSql := '
    CREATE TEMPORARY TABLE tmp_recursos_processados_exercicios_anteriores AS

      SELECT CASE WHEN restos_pre_empenho.recurso IS NOT NULL
                  THEN restos_pre_empenho.recurso
                  ELSE busca_recurso.cod_recurso
              END AS cod_recurso
           , liquidado.cod_empenho
           , liquidado.cod_entidade
           , CASE WHEN restos_pre_empenho.recurso IS NOT NULL
                  THEN (SELECT nom_recurso FROM orcamento.recurso('''||stExercicio||''') WHERE cod_recurso = restos_pre_empenho.recurso)
                  ELSE (SELECT nom_recurso FROM orcamento.recurso('''||stExercicio||''') WHERE cod_recurso = busca_recurso.cod_recurso)
              END AS nom_recurso
           , sw_cgm.nom_cgm as nom_entidade
           , CASE WHEN restos_pre_empenho.cod_estrutural IS NOT NULL
                  THEN (  CASE WHEN SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),1,2) = ''00''
                               THEN SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),5,2)
                               ELSE SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),3,2)
                          END
                       )
                  ELSE SUBSTR(REPLACE(conta_despesa.cod_estrutural,''.'',''''),3,2)
             END AS cod_estrutural
           , ( SUM(COALESCE(liquidado.vl_liquidado,0.00)) - SUM(COALESCE(pago.vl_pago,0.00)) ) AS vl_total
        FROM (  SELECT pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_empenho
                     , empenho.cod_entidade
                     , ( SUM(liquidado.vl_total) ) AS vl_liquidado
                  FROM empenho.nota_liquidacao

            INNER JOIN empenho.empenho
                    ON empenho.exercicio = nota_liquidacao.exercicio_empenho
                   AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                   AND empenho.cod_empenho = nota_liquidacao.cod_empenho

            INNER JOIN empenho.pre_empenho
                    ON pre_empenho.exercicio = empenho.exercicio
                   AND pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho

             LEFT JOIN (  SELECT nota_liquidacao_item.exercicio
                               , nota_liquidacao_item.cod_entidade
                               , nota_liquidacao_item.cod_nota
                               , ( SUM(COALESCE(nota_liquidacao_item.vl_total,0.00)) - SUM(COALESCE(nota_liquidacao_item_anulado.vl_anulado,0.00)) ) AS vl_total
                            FROM empenho.nota_liquidacao_item
                       LEFT JOIN (  SELECT exercicio
                                         , cod_nota
                                         , num_item
                                         , exercicio_item
                                         , cod_pre_empenho
                                         , cod_entidade
                                         , SUM(COALESCE(vl_anulado,0.00)) AS vl_anulado
                                      FROM empenho.nota_liquidacao_item_anulado
                                     WHERE TO_DATE(timestamp::varchar,''yyyy-mm-dd'') <= TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                                       AND cod_entidade IN ('||stCodEntidade||')
                                  GROUP BY exercicio
                                         , cod_nota
                                         , num_item
                                         , exercicio_item
                                         , cod_pre_empenho
                                         , cod_entidade
                                 ) AS nota_liquidacao_item_anulado
                              ON nota_liquidacao_item_anulado.exercicio = nota_liquidacao_item.exercicio
                             AND nota_liquidacao_item_anulado.cod_nota = nota_liquidacao_item.cod_nota
                             AND nota_liquidacao_item_anulado.num_item = nota_liquidacao_item.num_item
                             AND nota_liquidacao_item_anulado.exercicio_item = nota_liquidacao_item.exercicio_item
                             AND nota_liquidacao_item_anulado.cod_pre_empenho = nota_liquidacao_item.cod_pre_empenho
                             AND nota_liquidacao_item_anulado.cod_entidade = nota_liquidacao_item.cod_entidade
                           WHERE nota_liquidacao_item.cod_entidade  IN ('||stCodEntidade||')
                        GROUP BY nota_liquidacao_item.exercicio
                               , nota_liquidacao_item.cod_entidade
                               , nota_liquidacao_item.cod_nota

                       ) AS liquidado
                    ON liquidado.exercicio = nota_liquidacao.exercicio
                   AND liquidado.cod_entidade = nota_liquidacao.cod_entidade
                   AND liquidado.cod_nota = nota_liquidacao.cod_nota

                 WHERE empenho.exercicio < '''||stExercicioAnterior||'''
                   AND empenho.dt_empenho < TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'')
                   AND nota_liquidacao.dt_liquidacao <= TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                   AND empenho.cod_entidade IN ('||stCodEntidade||')

              GROUP BY pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_entidade
                     , empenho.cod_empenho
             ) AS liquidado
     LEFT JOIN (  SELECT ( SUM(liquidacao_paga.vl_total) ) AS vl_pago
                       , pre_empenho.exercicio
                       , pre_empenho.cod_pre_empenho
                       , empenho.cod_empenho
                       , empenho.cod_entidade

                    FROM empenho.nota_liquidacao

              INNER JOIN empenho.empenho
                      ON empenho.exercicio = nota_liquidacao.exercicio_empenho
                     AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                     AND empenho.cod_empenho = nota_liquidacao.cod_empenho

              INNER JOIN empenho.pre_empenho
                      ON pre_empenho.exercicio = empenho.exercicio
                     AND pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho

              INNER JOIN (  SELECT nota_liquidacao_paga.exercicio
                                 , nota_liquidacao_paga.cod_entidade
                                 , nota_liquidacao_paga.cod_nota
                                 , ( SUM(COALESCE(nota_liquidacao_paga.vl_total,0.00)) - SUM(COALESCE(nota_liquidacao_paga_anulada.vl_anulado,0.00)) ) AS vl_total

                              FROM (  SELECT nota_liquidacao_paga.exercicio
                                            , nota_liquidacao_paga.cod_entidade
                                           , nota_liquidacao_paga.cod_nota
                                           , SUM(nota_liquidacao_paga.vl_pago) AS vl_total
                                        FROM empenho.nota_liquidacao_paga
                                       WHERE TO_DATE(nota_liquidacao_paga.timestamp::varchar,''yyyy-mm-dd'') <= TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                                         AND nota_liquidacao_paga.cod_entidade IN ('||stCodEntidade||')
                                    GROUP BY nota_liquidacao_paga.exercicio
                                           , nota_liquidacao_paga.cod_entidade
                                           , nota_liquidacao_paga.cod_nota
                                   ) AS nota_liquidacao_paga

                         LEFT JOIN (  SELECT nota_liquidacao_paga_anulada.exercicio
                                           , nota_liquidacao_paga_anulada.cod_entidade
                                           , nota_liquidacao_paga_anulada.cod_nota
                                           , SUM(COALESCE(nota_liquidacao_paga_anulada.vl_anulado,0.00)) AS vl_anulado
                                        FROM empenho.nota_liquidacao_paga_anulada
                                       WHERE TO_DATE(nota_liquidacao_paga_anulada.timestamp_anulada::varchar,''yyyy-mm-dd'') < TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                                         AND nota_liquidacao_paga_anulada.cod_entidade IN ('||stCodEntidade||')
                                    GROUP BY nota_liquidacao_paga_anulada.exercicio
                                           , nota_liquidacao_paga_anulada.cod_entidade
                                           , nota_liquidacao_paga_anulada.cod_nota
                                   ) AS nota_liquidacao_paga_anulada
                                ON nota_liquidacao_paga_anulada.exercicio = nota_liquidacao_paga.exercicio
                               AND nota_liquidacao_paga_anulada.cod_entidade = nota_liquidacao_paga.cod_entidade
                               AND nota_liquidacao_paga_anulada.cod_nota = nota_liquidacao_paga.cod_nota
                          GROUP BY nota_liquidacao_paga.exercicio
                                 , nota_liquidacao_paga.cod_entidade
                                 , nota_liquidacao_paga.cod_nota

                         ) AS liquidacao_paga
                      ON liquidacao_paga.exercicio = nota_liquidacao.exercicio
                     AND liquidacao_paga.cod_entidade = nota_liquidacao.cod_entidade
                     AND liquidacao_paga.cod_nota = nota_liquidacao.cod_nota

                 WHERE empenho.exercicio < '''||stExercicioAnterior||'''
                   AND empenho.dt_empenho < TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'')
                   AND nota_liquidacao.dt_liquidacao <= TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                   AND empenho.cod_entidade IN ('||stCodEntidade||')

              GROUP BY pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_empenho
                     , empenho.cod_entidade

               ) AS pago
            ON pago.exercicio = liquidado.exercicio
           AND pago.cod_pre_empenho = liquidado.cod_pre_empenho
           AND pago.cod_entidade = liquidado.cod_entidade
           AND pago.cod_empenho = liquidado.cod_empenho

-- inner para achar a entidade a que ele pertence
    INNER JOIN orcamento.entidade
            ON entidade.exercicio = liquidado.exercicio
           AND entidade.cod_entidade = liquidado.cod_entidade

    INNER JOIN sw_cgm
            ON sw_cgm.numcgm = entidade.numcgm

--left para achar o cod_estrutural
     LEFT JOIN empenho.pre_empenho_despesa
            ON pre_empenho_despesa.exercicio = liquidado.exercicio
           AND pre_empenho_despesa.cod_pre_empenho = liquidado.cod_pre_empenho

     LEFT JOIN ( SELECT d.exercicio
                      , d.cod_despesa
                      , recurso.cod_recurso
                      , recurso.nom_recurso
                   FROM orcamento.despesa as d
                        LEFT JOIN ( SELECT r.exercicio
                                         , r.cod_recurso
                                         , r.nom_recurso
                                      FROM orcamento.recurso as r ) as recurso
                               ON (     recurso.exercicio   = d.exercicio
                                    AND recurso.cod_recurso = d.cod_recurso )
                  WHERE d.cod_entidade IN ('||stCodEntidade||')                   ) as busca_recurso
            ON busca_recurso.exercicio = pre_empenho_despesa.exercicio
           AND busca_recurso.cod_despesa = pre_empenho_despesa.cod_despesa

     LEFT JOIN orcamento.conta_despesa
            ON conta_despesa.exercicio = pre_empenho_despesa.exercicio
           AND conta_despesa.cod_conta = pre_empenho_despesa.cod_conta

     LEFT JOIN empenho.restos_pre_empenho
            ON restos_pre_empenho.exercicio = liquidado.exercicio
           AND restos_pre_empenho.cod_pre_empenho = liquidado.cod_pre_empenho
     LEFT JOIN orcamento.recurso AS recurso_restos
            ON restos_pre_empenho.recurso = recurso_restos.cod_recurso
           AND restos_pre_empenho.exercicio = liquidado.exercicio

      GROUP BY busca_recurso.cod_recurso
             , restos_pre_empenho.recurso
             , liquidado.cod_empenho
             , liquidado.cod_entidade
             , sw_cgm.nom_cgm
             , restos_pre_empenho.cod_estrutural
             , conta_despesa.cod_estrutural
  ';


  EXECUTE stSql;

  -- cria a tabela temporaria para o valor processado no exercicio anterior
  stSql := '
    CREATE TEMPORARY TABLE tmp_recursos_processados_exercicio_anterior AS

      SELECT CASE WHEN restos_pre_empenho.recurso IS NOT NULL
                  THEN restos_pre_empenho.recurso
                  ELSE busca_recurso.cod_recurso
              END AS cod_recurso
           , liquidado.cod_empenho
           , liquidado.cod_entidade
           , CASE WHEN restos_pre_empenho.recurso IS NOT NULL
                  THEN (SELECT nom_recurso FROM orcamento.recurso('''||stExercicio||''') WHERE cod_recurso = restos_pre_empenho.recurso)
                  ELSE (SELECT nom_recurso FROM orcamento.recurso('''||stExercicio||''') WHERE cod_recurso = busca_recurso.cod_recurso)
              END AS nom_recurso
           , sw_cgm.nom_cgm as nom_entidade
           , CASE WHEN restos_pre_empenho.cod_estrutural IS NOT NULL
                  THEN (  CASE WHEN SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),1,2) = ''00''
                               THEN SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),5,2)
                               ELSE SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),3,2)
                          END
                       )
                  ELSE SUBSTR(REPLACE(conta_despesa.cod_estrutural,''.'',''''),3,2)
             END AS cod_estrutural
           , ( SUM(COALESCE(liquidado.vl_liquidado,0.00)) - SUM(COALESCE(pago.vl_pago,0.00)) ) AS vl_total
        FROM (  SELECT pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_entidade
                     , empenho.cod_empenho
                     , ( SUM(liquidado.vl_total) ) AS vl_liquidado
                  FROM empenho.nota_liquidacao

            INNER JOIN empenho.empenho
                    ON empenho.exercicio = nota_liquidacao.exercicio_empenho
                   AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                   AND empenho.cod_empenho = nota_liquidacao.cod_empenho

            INNER JOIN empenho.pre_empenho
                    ON pre_empenho.exercicio = empenho.exercicio
                   AND pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho

             LEFT JOIN (  SELECT nota_liquidacao_item.exercicio
                               , nota_liquidacao_item.cod_entidade
                               , nota_liquidacao_item.cod_nota
                               , ( SUM(COALESCE(nota_liquidacao_item.vl_total,0.00)) - SUM(COALESCE(nota_liquidacao_item_anulado.vl_anulado,0.00)) ) AS vl_total
                            FROM empenho.nota_liquidacao_item
                                 LEFT JOIN (  SELECT exercicio
                                                   , cod_nota
                                                   , num_item
                                                   , exercicio_item
                                                   , cod_pre_empenho
                                                   , cod_entidade
                                                   , SUM(COALESCE(vl_anulado,0.00)) AS vl_anulado
                                                FROM empenho.nota_liquidacao_item_anulado
                                               WHERE TO_DATE(timestamp::varchar,''yyyy-mm-dd'') BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                                                 AND nota_liquidacao_item_anulado.cod_entidade IN ('||stCodEntidade||')
                                            GROUP BY exercicio
                                                   , cod_nota
                                                   , num_item
                                                   , exercicio_item
                                                   , cod_pre_empenho
                                                   , cod_entidade
                                           ) AS nota_liquidacao_item_anulado
                                        ON nota_liquidacao_item_anulado.exercicio = nota_liquidacao_item.exercicio
                                       AND nota_liquidacao_item_anulado.cod_nota = nota_liquidacao_item.cod_nota
                                       AND nota_liquidacao_item_anulado.num_item = nota_liquidacao_item.num_item
                                       AND nota_liquidacao_item_anulado.exercicio_item = nota_liquidacao_item.exercicio_item
                                       AND nota_liquidacao_item_anulado.cod_pre_empenho = nota_liquidacao_item.cod_pre_empenho
                                       AND nota_liquidacao_item_anulado.cod_entidade = nota_liquidacao_item.cod_entidade
                           WHERE nota_liquidacao_item.cod_entidade IN ('||stCodEntidade||')
                        GROUP BY nota_liquidacao_item.exercicio
                               , nota_liquidacao_item.cod_entidade
                               , nota_liquidacao_item.cod_nota

                       ) AS liquidado
                    ON liquidado.exercicio = nota_liquidacao.exercicio
                   AND liquidado.cod_entidade = nota_liquidacao.cod_entidade
                   AND liquidado.cod_nota = nota_liquidacao.cod_nota

                 WHERE empenho.exercicio = '''||stExercicioAnterior||'''
                   AND empenho.dt_empenho BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''31/12/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'')
                   AND nota_liquidacao.dt_liquidacao BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                   AND empenho.cod_entidade IN ('||stCodEntidade||')

              GROUP BY pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_entidade
                     , empenho.cod_empenho
             ) AS liquidado
     LEFT JOIN (  SELECT ( SUM(liquidacao_paga.vl_total) ) AS vl_pago
                       , pre_empenho.exercicio
                       , pre_empenho.cod_pre_empenho
                       , empenho.cod_entidade
                       , empenho.cod_empenho
                    FROM empenho.nota_liquidacao

              INNER JOIN empenho.empenho
                      ON empenho.exercicio = nota_liquidacao.exercicio_empenho
                     AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                     AND empenho.cod_empenho = nota_liquidacao.cod_empenho

              INNER JOIN empenho.pre_empenho
                      ON pre_empenho.exercicio = empenho.exercicio
                     AND pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho

              INNER JOIN (  SELECT nota_liquidacao_paga.exercicio
                                 , nota_liquidacao_paga.cod_entidade
                                 , nota_liquidacao_paga.cod_nota
                                 , ( SUM(COALESCE(nota_liquidacao_paga.vl_total,0.00)) - SUM(COALESCE(nota_liquidacao_paga_anulada.vl_anulado,0.00)) ) AS vl_total

                              FROM (  SELECT nota_liquidacao_paga.exercicio
                                            , nota_liquidacao_paga.cod_entidade
                                           , nota_liquidacao_paga.cod_nota
                                           , SUM(nota_liquidacao_paga.vl_pago) AS vl_total
                                        FROM empenho.nota_liquidacao_paga
                                       WHERE TO_DATE(nota_liquidacao_paga.timestamp::varchar,''yyyy-mm-dd'') BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                                         AND nota_liquidacao_paga.cod_entidade IN ('||stCodEntidade||')
                                    GROUP BY nota_liquidacao_paga.exercicio
                                           , nota_liquidacao_paga.cod_entidade
                                           , nota_liquidacao_paga.cod_nota
                                   ) AS nota_liquidacao_paga

                         LEFT JOIN (  SELECT nota_liquidacao_paga_anulada.exercicio
                                           , nota_liquidacao_paga_anulada.cod_entidade
                                           , nota_liquidacao_paga_anulada.cod_nota
                                           , SUM(COALESCE(nota_liquidacao_paga_anulada.vl_anulado,0.00)) AS vl_anulado
                                        FROM empenho.nota_liquidacao_paga_anulada
                                       WHERE TO_DATE(nota_liquidacao_paga_anulada.timestamp_anulada::varchar,''yyyy-mm-dd'') BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                                         AND nota_liquidacao_paga_anulada.cod_entidade IN ('||stCodEntidade||')
                                    GROUP BY nota_liquidacao_paga_anulada.exercicio
                                           , nota_liquidacao_paga_anulada.cod_entidade
                                           , nota_liquidacao_paga_anulada.cod_nota
                                   ) AS nota_liquidacao_paga_anulada
                                ON nota_liquidacao_paga_anulada.exercicio = nota_liquidacao_paga.exercicio
                               AND nota_liquidacao_paga_anulada.cod_entidade = nota_liquidacao_paga.cod_entidade
                               AND nota_liquidacao_paga_anulada.cod_nota = nota_liquidacao_paga.cod_nota
                          GROUP BY nota_liquidacao_paga.exercicio
                                 , nota_liquidacao_paga.cod_entidade
                                 , nota_liquidacao_paga.cod_nota

                         ) AS liquidacao_paga
                      ON liquidacao_paga.exercicio = nota_liquidacao.exercicio
                     AND liquidacao_paga.cod_entidade = nota_liquidacao.cod_entidade
                     AND liquidacao_paga.cod_nota = nota_liquidacao.cod_nota

                 WHERE empenho.exercicio = '''||stExercicioAnterior||'''
                   AND empenho.dt_empenho BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''31/12/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'')
                   AND nota_liquidacao.dt_liquidacao BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                   AND empenho.cod_entidade IN ('||stCodEntidade||')

              GROUP BY pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_entidade
                     , empenho.cod_empenho
               ) AS pago
            ON pago.exercicio = liquidado.exercicio
           AND pago.cod_pre_empenho = liquidado.cod_pre_empenho
           AND pago.cod_entidade = liquidado.cod_entidade
           AND pago.cod_empenho = liquidado.cod_empenho

-- inner para achar a entidade a que ele pertence
    INNER JOIN orcamento.entidade
            ON entidade.exercicio = liquidado.exercicio
           AND entidade.cod_entidade = liquidado.cod_entidade

    INNER JOIN sw_cgm
            ON sw_cgm.numcgm = entidade.numcgm

--left para achar o cod_estrutural
     LEFT JOIN empenho.pre_empenho_despesa
            ON pre_empenho_despesa.exercicio = liquidado.exercicio
           AND pre_empenho_despesa.cod_pre_empenho = liquidado.cod_pre_empenho

     LEFT JOIN ( SELECT d.exercicio
                      , d.cod_despesa
                      , recurso.cod_recurso
                      , recurso.nom_recurso
                   FROM orcamento.despesa as d
                        LEFT JOIN ( SELECT r.exercicio
                                         , r.cod_recurso
                                         , r.nom_recurso
                                      FROM orcamento.recurso as r ) as recurso
                               ON (     recurso.exercicio   = d.exercicio
                                    AND recurso.cod_recurso = d.cod_recurso )
                  WHERE d.cod_entidade IN ('||stCodEntidade||')                                ) as busca_recurso
            ON busca_recurso.exercicio = pre_empenho_despesa.exercicio
           AND busca_recurso.cod_despesa = pre_empenho_despesa.cod_despesa

     LEFT JOIN orcamento.conta_despesa
            ON conta_despesa.exercicio = pre_empenho_despesa.exercicio
           AND conta_despesa.cod_conta = pre_empenho_despesa.cod_conta

     LEFT JOIN empenho.restos_pre_empenho
            ON restos_pre_empenho.exercicio = liquidado.exercicio
           AND restos_pre_empenho.cod_pre_empenho = liquidado.cod_pre_empenho
     LEFT JOIN orcamento.recurso AS recurso_restos
            ON restos_pre_empenho.recurso = recurso_restos.cod_recurso
           AND restos_pre_empenho.exercicio = liquidado.exercicio

      GROUP BY busca_recurso.cod_recurso
             , restos_pre_empenho.recurso
             , liquidado.cod_empenho
             , liquidado.cod_entidade
             , sw_cgm.nom_cgm
             , restos_pre_empenho.cod_estrutural
             , conta_despesa.cod_estrutural
  ';

  EXECUTE stSql;

  -- cria a tabela temporaria para o valor nao processado em exercicios anteriores
  StSql := '
    CREATE TEMPORARY TABLE tmp_recursos_nao_processados_exercicios_anteriores AS

      SELECT CASE WHEN restos_pre_empenho.recurso IS NOT NULL
                  THEN restos_pre_empenho.recurso
                  ELSE busca_recurso.cod_recurso
              END AS cod_recurso
           , empenhado.cod_empenho
           , empenhado.cod_entidade
           , CASE WHEN restos_pre_empenho.recurso IS NOT NULL
                 THEN (SELECT nom_recurso FROM orcamento.recurso('''||stExercicio||''') WHERE cod_recurso = restos_pre_empenho.recurso)
                 ELSE (SELECT nom_recurso FROM orcamento.recurso('''||stExercicio||''') WHERE cod_recurso = busca_recurso.cod_recurso)
             END AS nom_recurso
           , sw_cgm.nom_cgm as nom_entidade
           , CASE WHEN restos_pre_empenho.cod_estrutural IS NOT NULL
                  THEN (  CASE WHEN SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),1,2) = ''00''
                               THEN SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),5,2)
                               ELSE SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),3,2)
                          END
                       )
                  ELSE SUBSTR(REPLACE(conta_despesa.cod_estrutural,''.'',''''),3,2)
             END AS cod_estrutural
           , (SUM(COALESCE(empenhado.vl_empenhado,0.00)) - SUM(COALESCE(liquidado.vl_liquidado,0.00))) AS vl_total
        FROM (  SELECT (  SUM(COALESCE(item_pre_empenho.vl_total,0.00))
                          -
                          SUM(COALESCE(empenho_anulado_item.vl_anulado,0.00)) ) AS vl_empenhado
                     , pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_entidade
                     , empenho.cod_empenho
                  FROM empenho.empenho

            INNER JOIN empenho.pre_empenho
                    ON pre_empenho.exercicio = empenho.exercicio
                   AND pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho

            INNER JOIN empenho.item_pre_empenho
                    ON item_pre_empenho.exercicio = pre_empenho.exercicio
                   AND item_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho

             LEFT JOIN (  SELECT empenho_anulado_item.exercicio
                               , empenho_anulado_item.cod_pre_empenho
                               , empenho_anulado_item.num_item
                               , SUM(empenho_anulado_item.vl_anulado) AS vl_anulado
                            FROM empenho.empenho_anulado_item
                           WHERE TO_DATE(empenho_anulado_item.timestamp::varchar,''yyyy-mm-dd'') <= TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                             AND empenho_anulado_item.cod_entidade  IN ('||stCodEntidade||')
                        GROUP BY empenho_anulado_item.exercicio
                               , empenho_anulado_item.cod_pre_empenho
                               , empenho_anulado_item.num_item
                       ) AS empenho_anulado_item
                    ON empenho_anulado_item.exercicio = item_pre_empenho.exercicio
                   AND empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                   AND empenho_anulado_item.num_item = item_pre_empenho.num_item

                 WHERE empenho.exercicio < '''||stExercicioAnterior||'''
                   AND empenho.dt_empenho < TO_DATE(''31/12/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'')
                   AND empenho.cod_entidade IN ('||stCodEntidade||')
              GROUP BY pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_entidade
                     , empenho.cod_empenho
             ) AS empenhado

     LEFT JOIN (  SELECT ( SUM(COALESCE(liquidado.vl_total,0.00)) ) AS vl_liquidado
                       , pre_empenho.exercicio
                       , pre_empenho.cod_pre_empenho
                       , empenho.cod_entidade
                       , empenho.cod_empenho
                    FROM empenho.nota_liquidacao

              INNER JOIN empenho.empenho
                      ON empenho.exercicio = nota_liquidacao.exercicio_empenho
                     AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                     AND empenho.cod_empenho = nota_liquidacao.cod_empenho

              INNER JOIN empenho.pre_empenho
                      ON pre_empenho.exercicio = empenho.exercicio
                     AND pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho

               LEFT JOIN (  SELECT nota_liquidacao_item.exercicio
                                 , nota_liquidacao_item.cod_entidade
                                 , nota_liquidacao_item.cod_nota
                                 , ( SUM(COALESCE(nota_liquidacao_item.vl_total,0.00)) - SUM(COALESCE(nota_liquidacao_item_anulado.vl_anulado,0.00)) ) AS vl_total
                              FROM empenho.nota_liquidacao_item
                         LEFT JOIN (  SELECT exercicio
                                           , cod_nota
                                           , num_item
                                           , exercicio_item
                                           , cod_pre_empenho
                                           , cod_entidade
                                           , SUM(COALESCE(vl_anulado,0.00)) AS vl_anulado
                                        FROM empenho.nota_liquidacao_item_anulado
                                       WHERE TO_DATE(timestamp::varchar,''yyyy-mm-dd'') <= TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                                         AND nota_liquidacao_item_anulado.cod_entidade IN ('||stCodEntidade||')
                                    GROUP BY exercicio
                                           , cod_nota
                                           , num_item
                                           , exercicio_item
                                           , cod_pre_empenho
                                           , cod_entidade
                                   ) AS nota_liquidacao_item_anulado
                                ON nota_liquidacao_item_anulado.exercicio = nota_liquidacao_item.exercicio
                               AND nota_liquidacao_item_anulado.cod_nota = nota_liquidacao_item.cod_nota
                               AND nota_liquidacao_item_anulado.num_item = nota_liquidacao_item.num_item
                               AND nota_liquidacao_item_anulado.exercicio_item = nota_liquidacao_item.exercicio_item
                               AND nota_liquidacao_item_anulado.cod_pre_empenho = nota_liquidacao_item.cod_pre_empenho
                               AND nota_liquidacao_item_anulado.cod_entidade = nota_liquidacao_item.cod_entidade
                             WHERE nota_liquidacao_item.cod_entidade  IN ('||stCodEntidade||')
                          GROUP BY nota_liquidacao_item.exercicio
                                 , nota_liquidacao_item.cod_entidade
                                 , nota_liquidacao_item.cod_nota

                       ) AS liquidado
                      ON liquidado.exercicio = nota_liquidacao.exercicio
                     AND liquidado.cod_entidade = nota_liquidacao.cod_entidade
                     AND liquidado.cod_nota = nota_liquidacao.cod_nota

                   WHERE empenho.exercicio < '''||stExercicioAnterior||'''
                     AND empenho.dt_empenho < TO_DATE(''31/12/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'')

                     AND nota_liquidacao.dt_liquidacao <= TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                     AND empenho.cod_entidade IN ('||stCodEntidade||')
                GROUP BY pre_empenho.exercicio
                       , pre_empenho.cod_pre_empenho
                       , empenho.cod_entidade
                       , empenho.cod_empenho

               ) AS liquidado
            ON liquidado.exercicio = empenhado.exercicio
           AND liquidado.cod_pre_empenho = empenhado.cod_pre_empenho
           AND liquidado.cod_entidade = empenhado.cod_entidade
           AND liquidado.cod_empenho = empenhado.cod_empenho

-- inner para achar a entidade a que ele pertence
    INNER JOIN orcamento.entidade
            ON entidade.exercicio = empenhado.exercicio
           AND entidade.cod_entidade = empenhado.cod_entidade

    INNER JOIN sw_cgm
            ON sw_cgm.numcgm = entidade.numcgm

--left para achar o cod_estrutural
     LEFT JOIN empenho.pre_empenho_despesa
            ON pre_empenho_despesa.exercicio = empenhado.exercicio
           AND pre_empenho_despesa.cod_pre_empenho = empenhado.cod_pre_empenho

   LEFT JOIN ( SELECT d.exercicio
                    , d.cod_despesa
                    , recurso.cod_recurso
                    , recurso.nom_recurso
                 FROM orcamento.despesa as d
                      LEFT JOIN ( SELECT r.exercicio
                                       , r.cod_recurso
                                       , r.nom_recurso
                                    FROM orcamento.recurso as r ) as recurso
                             ON (     recurso.exercicio   = d.exercicio
                                  AND recurso.cod_recurso = d.cod_recurso )
                WHERE d.cod_entidade IN ('||stCodEntidade||')                            ) as busca_recurso
          ON busca_recurso.exercicio = pre_empenho_despesa.exercicio
         AND busca_recurso.cod_despesa = pre_empenho_despesa.cod_despesa

     LEFT JOIN orcamento.conta_despesa
            ON conta_despesa.exercicio = pre_empenho_despesa.exercicio
           AND conta_despesa.cod_conta = pre_empenho_despesa.cod_conta

     LEFT JOIN empenho.restos_pre_empenho
            ON restos_pre_empenho.exercicio = empenhado.exercicio
           AND restos_pre_empenho.cod_pre_empenho = empenhado.cod_pre_empenho
     LEFT JOIN orcamento.recurso AS recurso_restos
            ON restos_pre_empenho.recurso = recurso_restos.cod_recurso
           AND restos_pre_empenho.exercicio = empenhado.exercicio

      GROUP BY busca_recurso.cod_recurso
             , restos_pre_empenho.recurso
             , sw_cgm.nom_cgm
             , restos_pre_empenho.cod_estrutural
             , conta_despesa.cod_estrutural
             , empenhado.cod_empenho
             , empenhado.cod_entidade
  ';

  EXECUTE stSql;

  -- cria a tabela temporaria para o valor nao processado no exercicio anterior
  StSql := '
    CREATE TEMPORARY TABLE tmp_recursos_nao_processados_exercicio_anterior AS

      SELECT CASE WHEN restos_pre_empenho.recurso IS NOT NULL
                  THEN restos_pre_empenho.recurso
                  ELSE busca_recurso.cod_recurso
              END AS cod_recurso
           , empenhado.cod_empenho
           , empenhado.cod_entidade
           , CASE WHEN restos_pre_empenho.recurso IS NOT NULL
                 THEN (SELECT nom_recurso FROM orcamento.recurso('''||stExercicio||''') WHERE cod_recurso = restos_pre_empenho.recurso)
                 ELSE (SELECT nom_recurso FROM orcamento.recurso('''||stExercicio||''') WHERE cod_recurso = busca_recurso.cod_recurso)
             END AS nom_recurso
           , sw_cgm.nom_cgm as nom_entidade
           , CASE WHEN restos_pre_empenho.cod_estrutural IS NOT NULL
                  THEN (  CASE WHEN SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),1,2) = ''00''
                               THEN SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),5,2)
                               ELSE SUBSTR(REPLACE(restos_pre_empenho.cod_estrutural,''.'',''''),3,2)
                          END
                       )
                  ELSE SUBSTR(REPLACE(conta_despesa.cod_estrutural,''.'',''''),3,2)
             END AS cod_estrutural

           , (SUM(COALESCE(empenhado.vl_empenhado,0.00)) - SUM(COALESCE(liquidado.vl_liquidado,0.00))) AS vl_total
        FROM (  SELECT (  SUM(COALESCE(item_pre_empenho.vl_total,0.00))
                          -
                          SUM(COALESCE(empenho_anulado_item.vl_anulado,0.00)) ) AS vl_empenhado
                     , pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_entidade
                     , empenho.cod_empenho

                  FROM empenho.empenho

            INNER JOIN empenho.pre_empenho
                    ON pre_empenho.exercicio = empenho.exercicio
                   AND pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho

            INNER JOIN empenho.item_pre_empenho
                    ON item_pre_empenho.exercicio = pre_empenho.exercicio
                   AND item_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho

             LEFT JOIN (  SELECT empenho_anulado_item.exercicio
                               , empenho_anulado_item.cod_pre_empenho
                               , empenho_anulado_item.num_item
                               , SUM(empenho_anulado_item.vl_anulado) AS vl_anulado
                            FROM empenho.empenho_anulado_item
                           WHERE TO_DATE(empenho_anulado_item.timestamp::varchar,''yyyy-mm-dd'') BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''01/01/'|| stExercicio||'''::varchar,''dd/mm/yyyy'')
                        GROUP BY empenho_anulado_item.exercicio
                               , empenho_anulado_item.cod_pre_empenho
                               , empenho_anulado_item.num_item
                       ) AS empenho_anulado_item
                    ON empenho_anulado_item.exercicio = item_pre_empenho.exercicio
                   AND empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                   AND empenho_anulado_item.num_item = item_pre_empenho.num_item

                 WHERE empenho.exercicio = '''|| stExercicioAnterior ||'''
                   AND empenho.dt_empenho BETWEEN TO_DATE(''01/01/'|| stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''31/12/'|| stExercicioAnterior||'''::varchar,''dd/mm/yyyy'')
                   AND empenho.cod_entidade IN ('|| stCodEntidade ||')
              GROUP BY pre_empenho.exercicio
                     , pre_empenho.cod_pre_empenho
                     , empenho.cod_entidade
                     , empenho.cod_empenho
             ) AS empenhado

     LEFT JOIN (  SELECT ( SUM(liquidado.vl_total) ) AS vl_liquidado
                       , pre_empenho.exercicio
                       , pre_empenho.cod_pre_empenho
                       , empenho.cod_entidade
                       , empenho.cod_empenho

                    FROM empenho.nota_liquidacao

              INNER JOIN empenho.empenho
                      ON empenho.exercicio = nota_liquidacao.exercicio_empenho
                     AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                     AND empenho.cod_empenho = nota_liquidacao.cod_empenho

              INNER JOIN empenho.pre_empenho
                      ON pre_empenho.exercicio = empenho.exercicio
                     AND pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho

               LEFT JOIN (  SELECT nota_liquidacao_item.exercicio
                                 , nota_liquidacao_item.cod_entidade
                                 , nota_liquidacao_item.cod_nota
                                 , ( SUM(COALESCE(nota_liquidacao_item.vl_total,0.00)) - SUM(COALESCE(nota_liquidacao_item_anulado.vl_anulado,0.00)) ) AS vl_total
                              FROM empenho.nota_liquidacao_item
                                   LEFT JOIN (  SELECT exercicio
                                                     , cod_nota
                                                     , num_item
                                                     , exercicio_item
                                                     , cod_pre_empenho
                                                     , cod_entidade
                                                     , SUM(COALESCE(vl_anulado,0.00)) AS vl_anulado
                                                  FROM empenho.nota_liquidacao_item_anulado
                                                 WHERE TO_DATE(timestamp::varchar,''yyyy-mm-dd'') BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                                              GROUP BY exercicio
                                                     , cod_nota
                                                     , num_item
                                                     , exercicio_item
                                                     , cod_pre_empenho
                                                     , cod_entidade
                                             ) AS nota_liquidacao_item_anulado
                                          ON nota_liquidacao_item_anulado.exercicio = nota_liquidacao_item.exercicio
                                         AND nota_liquidacao_item_anulado.cod_nota = nota_liquidacao_item.cod_nota
                                         AND nota_liquidacao_item_anulado.num_item = nota_liquidacao_item.num_item
                                         AND nota_liquidacao_item_anulado.exercicio_item = nota_liquidacao_item.exercicio_item
                                         AND nota_liquidacao_item_anulado.cod_pre_empenho = nota_liquidacao_item.cod_pre_empenho
                                         AND nota_liquidacao_item_anulado.cod_entidade = nota_liquidacao_item.cod_entidade
                             WHERE nota_liquidacao_item.cod_entidade IN ('|| stCodEntidade ||')
                          GROUP BY nota_liquidacao_item.exercicio
                                 , nota_liquidacao_item.cod_entidade
                                 , nota_liquidacao_item.cod_nota

                       ) AS liquidado
                      ON liquidado.exercicio = nota_liquidacao.exercicio
                     AND liquidado.cod_entidade = nota_liquidacao.cod_entidade
                     AND liquidado.cod_nota = nota_liquidacao.cod_nota
                   WHERE empenho.exercicio = '''||stExercicioAnterior||'''
                     AND empenho.dt_empenho BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''31/12/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'')
                     AND nota_liquidacao.dt_liquidacao BETWEEN TO_DATE(''01/01/'||stExercicioAnterior||'''::varchar,''dd/mm/yyyy'') AND TO_DATE(''01/01/'||stExercicio||'''::varchar,''dd/mm/yyyy'')
                     AND empenho.cod_entidade IN ('||stCodEntidade||')
                GROUP BY pre_empenho.exercicio
                       , pre_empenho.cod_pre_empenho
                       , empenho.cod_entidade
                       , empenho.cod_empenho

               ) AS liquidado
            ON liquidado.exercicio = empenhado.exercicio
           AND liquidado.cod_pre_empenho = empenhado.cod_pre_empenho
           AND liquidado.cod_entidade = empenhado.cod_entidade

-- inner para achar a entidade a que ele pertence
    INNER JOIN orcamento.entidade
            ON entidade.exercicio = empenhado.exercicio
           AND entidade.cod_entidade = empenhado.cod_entidade

    INNER JOIN sw_cgm
            ON sw_cgm.numcgm = entidade.numcgm

--left para achar o cod_estrutural
     LEFT JOIN empenho.pre_empenho_despesa
            ON pre_empenho_despesa.exercicio = empenhado.exercicio
           AND pre_empenho_despesa.cod_pre_empenho = empenhado.cod_pre_empenho

     LEFT JOIN ( SELECT d.exercicio
                      , d.cod_despesa
                      , recurso.cod_recurso
                      , recurso.nom_recurso
                   FROM orcamento.despesa as d
                        LEFT JOIN ( SELECT r.exercicio
                                         , r.cod_recurso
                                         , r.nom_recurso
                                      FROM orcamento.recurso as r ) as recurso
                               ON (     recurso.exercicio   = d.exercicio
                                    AND recurso.cod_recurso = d.cod_recurso )
                  WHERE d.cod_entidade IN ('||stCodEntidade||')                             ) as busca_recurso
            ON busca_recurso.exercicio = pre_empenho_despesa.exercicio
           AND busca_recurso.cod_despesa = pre_empenho_despesa.cod_despesa

     LEFT JOIN orcamento.conta_despesa
            ON conta_despesa.exercicio = pre_empenho_despesa.exercicio
           AND conta_despesa.cod_conta = pre_empenho_despesa.cod_conta

     LEFT JOIN empenho.restos_pre_empenho
            ON restos_pre_empenho.exercicio = empenhado.exercicio
           AND restos_pre_empenho.cod_pre_empenho = empenhado.cod_pre_empenho
     LEFT JOIN orcamento.recurso AS recurso_restos
            ON restos_pre_empenho.recurso = recurso_restos.cod_recurso
           AND restos_pre_empenho.exercicio = empenhado.exercicio

      GROUP BY busca_recurso.cod_recurso
             , restos_pre_empenho.recurso
             , sw_cgm.nom_cgm
             , restos_pre_empenho.cod_estrutural
             , conta_despesa.cod_estrutural
             , empenhado.cod_empenho
             , empenhado.cod_entidade
  ';

  EXECUTE stSql;

UPDATE tmp_recursos_processados_exercicios_anteriores     SET cod_recurso = 0, nom_recurso = 'Não Informado' WHERE cod_recurso is null;
UPDATE tmp_recursos_processados_exercicio_anterior        SET cod_recurso = 0, nom_recurso = 'Não Informado' WHERE cod_recurso is null;
UPDATE tmp_recursos_nao_processados_exercicios_anteriores SET cod_recurso = 0, nom_recurso = 'Não Informado' WHERE cod_recurso is null;
UPDATE tmp_recursos_nao_processados_exercicio_anterior    SET cod_recurso = 0, nom_recurso = 'Não Informado' WHERE cod_recurso is null;

--consulta para retornar todas os orgaos para nao intra-orcamentarias
  stSql := '
    CREATE TEMPORARY TABLE tmp_recursos_orgao AS
    SELECT *
      FROM (
      SELECT cod_recurso
           , nom_recurso
           , cod_entidade
        FROM tmp_recursos_processados_exercicios_anteriores
       UNION
      SELECT cod_recurso
           , nom_recurso
           , cod_entidade
        FROM tmp_recursos_processados_exercicio_anterior
       UNION
      SELECT cod_recurso
           , nom_recurso
           , cod_entidade
        FROM tmp_recursos_nao_processados_exercicios_anteriores
       UNION
      SELECT cod_recurso
           , nom_recurso
           , cod_entidade
        FROM tmp_recursos_nao_processados_exercicio_anterior

       --union para trazer os recursos para o saldo
       UNION
      SELECT recurso.cod_recurso
           , recurso.nom_recurso
           , plano_banco.cod_entidade
        FROM contabilidade.plano_recurso
  INNER JOIN contabilidade.plano_banco
          ON plano_recurso.cod_plano = plano_banco.cod_plano
         AND plano_recurso.exercicio = plano_banco.exercicio
  INNER JOIN orcamento.recurso('''||stExercicio||''')
          ON plano_recurso.cod_recurso = recurso.cod_recurso
         AND plano_recurso.exercicio   = recurso.exercicio
           ) AS tabela
       WHERE cod_entidade IN (' || stCodEntidade || ')
    GROUP BY cod_recurso, nom_recurso, cod_entidade
  ';

  EXECUTE stSql;


  stSql := '

      CREATE TEMPORARY TABLE tmp_recurso_liquidados_e_nao_liquidados_do_exercicio AS
      SELECT *
        FROM stn.fn_rel_rgf6_emp_liq_exercicio_recurso_entidade( '''||stCodEntidade||''', '''||stExercicio||''', '''||dtInicial||''', '''||dtFinal||''', '''||dtFinal||''' ) as retorno
             ( cod_recurso integer, nom_recurso varchar, cod_entidade integer, exercicio varchar, cod_plano_debito varchar, liquidados_nao_pagos numeric, empenhados_nao_liquidados numeric)

  ';

  EXECUTE stSql;


  stSql := '
    CREATE TEMPORARY TABLE tmp_recursos_resultados AS

    SELECT
           tlnl.cod_recurso
         , tlnl.nom_recurso as tipo
         , tlnl.cod_entidade
         , 0.00 AS tmp_recursos_processados_exercicios_anteriores
         , 0.00 AS tmp_recursos_processados_exercicio_anterior
         , 0.00 AS tmp_recursos_nao_processados_exercicios_anteriores
         , 0.00 AS tmp_recursos_nao_processados_exercicio_anterior
         , sum(coalesce(tlnl.liquidados_nao_pagos,0.00))        as liquidados_nao_pagos
         , sum(coalesce(tlnl.empenhados_nao_liquidados,0.00))   as empenhados_nao_liquidados
      FROM tmp_recurso_liquidados_e_nao_liquidados_do_exercicio    as tlnl
  GROUP BY tlnl.cod_recurso
         , tlnl.nom_recurso
         , tlnl.cod_entidade

    UNION ALL

    SELECT tmp_recursos_orgao.cod_recurso AS cod_recurso
         , tmp_recursos_orgao.nom_recurso AS tipo
         , tmp_recursos_orgao.cod_entidade
         , sum(coalesce(trpeas.vl_total,0.00))  AS tmp_recursos_processados_exercicios_anteriores
         , sum(coalesce(trpea.vl_total,0.00))   AS tmp_recursos_processados_exercicio_anterior
         , sum(coalesce(trnpeas.vl_total,0.00)) AS  tmp_recursos_nao_processados_exercicios_anteriores
         , sum(coalesce(trnpea.vl_total,0.00))  AS  tmp_recursos_nao_processados_exercicio_anterior
         , 0.00 as liquidados_nao_pagos
         , 0.00 as empenhados_nao_liquidados
      FROM tmp_recursos_orgao

 LEFT JOIN ( SELECT SUM(coalesce(vl_total,0.00)) as vl_total
                  , cod_recurso
                  , cod_entidade
               FROM tmp_recursos_processados_exercicios_anteriores
           GROUP BY cod_recurso, cod_entidade
           ) as trpeas
        ON trpeas.cod_recurso  = tmp_recursos_orgao.cod_recurso
       AND trpeas.cod_entidade = tmp_recursos_orgao.cod_entidade
 LEFT JOIN ( SELECT SUM(coalesce(vl_total,0.00)) as vl_total
                  , cod_recurso
                  , cod_entidade
               FROM tmp_recursos_processados_exercicio_anterior
           GROUP BY cod_recurso, cod_entidade
           )  as trpea
        ON trpea.cod_recurso  = tmp_recursos_orgao.cod_recurso
       AND trpea.cod_entidade = tmp_recursos_orgao.cod_entidade
 LEFT JOIN ( SELECT SUM(coalesce(vl_total,0.00)) as vl_total
                  , cod_recurso
                  , cod_entidade
               FROM tmp_recursos_nao_processados_exercicios_anteriores
           GROUP BY cod_recurso, cod_entidade
           )  as trnpeas
        ON trnpeas.cod_recurso  = tmp_recursos_orgao.cod_recurso
       AND trnpeas.cod_entidade = tmp_recursos_orgao.cod_entidade
 LEFT JOIN ( SELECT SUM(coalesce(vl_total,0.00)) as vl_total
                  , cod_recurso
                  , cod_entidade
               FROM tmp_recursos_nao_processados_exercicio_anterior
           GROUP BY cod_recurso, cod_entidade
           )  as trnpea
        ON trnpea.cod_recurso  = tmp_recursos_orgao.cod_recurso
       AND trnpea.cod_entidade = tmp_recursos_orgao.cod_entidade

   GROUP BY tmp_recursos_orgao.cod_recurso, tmp_recursos_orgao.nom_recurso,tmp_recursos_orgao.cod_entidade

  ';

  EXECUTE stSql;

  stSql := '
             SELECT * FROM tmp_recursos_resultados
           ';

  FOR reRegistro IN EXECUTE stSql
  LOOP
      RETURN next reRegistro;
  END LOOP;

  DROP TABLE tmp_recursos_processados_exercicios_anteriores;
  DROP TABLE tmp_recursos_processados_exercicio_anterior;
  DROP TABLE tmp_recursos_nao_processados_exercicios_anteriores;
  DROP TABLE tmp_recursos_nao_processados_exercicio_anterior;
  DROP TABLE tmp_recursos_orgao;
  DROP TABLE tmp_recursos_resultados;
  DROP TABLE tmp_recurso_liquidados_e_nao_liquidados_do_exercicio;
END;

$function$
