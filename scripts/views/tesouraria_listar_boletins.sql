CREATE OR REPLACE VIEW tesouraria.vw_boletins AS
    SELECT TB.cod_boletim
            ,TB.exercicio
            ,TB.cod_entidade
            ,TB.cod_terminal
            ,TB.timestamp_terminal
            ,TB.cgm_usuario
            ,TB.timestamp_usuario
            ,TBF.timestamp_fechamento
            ,TBR.timestamp_reabertura
            ,TO_CHAR( TB.dt_boletim, 'dd/mm/yyyy' ) as dt_boletim
            ,TO_CHAR( TBF.timestamp_fechamento, 'dd/mm/yyyy - HH24:mm:ss' ) as dt_fechamento
            ,CGM.nom_cgm
            ,TBL.timestamp_liberado
            ,CASE WHEN TBF.timestamp_fechamento IS NOT NULL
              THEN CASE WHEN TBR.timestamp_reabertura IS NOT NULL
                    THEN CASE WHEN TBF.timestamp_fechamento >= TBR.timestamp_reabertura
                          THEN CASE WHEN TBL.timestamp_liberado IS NOT NULL
                                THEN 'liberado'
                                ELSE 'fechado'
                               END
                          ELSE 'reaberto'
                         END
                    ELSE CASE WHEN TBL.timestamp_liberado IS NOT NULL
                           THEN 'liberado'
                           ELSE 'fechado'
                         END
                   END
              ELSE 'aberto'
             END AS situacao
      FROM tesouraria.boletim AS TB
      LEFT JOIN( SELECT TBF.cod_boletim
                       ,TBF.exercicio
                       ,TBF.cod_entidade
                       ,MAX( TBF.timestamp_fechamento ) as timestamp_fechamento
                 FROM tesouraria.boletim_fechado AS TBF
                 GROUP BY cod_boletim
                         ,exercicio
                         ,cod_entidade
                 ORDER BY cod_boletim
                         ,exercicio
                         ,cod_entidade
      ) AS TBF ON( TB.cod_boletim = TBF.cod_boletim
               AND TB.exercicio   = TBF.exercicio
               AND TB.cod_entidade= TBF.cod_entidade )
      LEFT JOIN( SELECT TBR.cod_boletim
                       ,TBR.exercicio
                       ,TBR.cod_entidade
                       ,MAX( TBR.timestamp_reabertura ) as timestamp_reabertura
                 FROM tesouraria.boletim_reaberto AS TBR
                 GROUP BY TBR.cod_boletim
                         ,TBR.exercicio
                         ,TBR.cod_entidade
                 ORDER BY TBR.cod_boletim
                         ,TBR.exercicio
                         ,TBR.cod_entidade
      ) AS TBR ON( TB.cod_boletim = TBR.cod_boletim
               AND TB.exercicio   = TBR.exercicio
               AND TB.cod_entidade= TBR.cod_entidade )
      LEFT JOIN( SELECT TBL.cod_boletim
                       ,TBL.exercicio
                       ,TBL.cod_entidade
                       ,MAX( TBL.timestamp_liberado  ) as timestamp_liberado
                 FROM tesouraria.boletim_liberado   AS TBL
                 GROUP BY TBL.cod_boletim
                         ,TBL.exercicio
                         ,TBL.cod_entidade
                 ORDER BY TBL.cod_boletim
                         ,TBL.exercicio
                         ,TBL.cod_entidade
      ) AS TBL ON( TB.cod_boletim = TBL.cod_boletim
               AND TB.exercicio   = TBL.exercicio
               AND TB.cod_entidade= TBL.cod_entidade )
      ,sw_cgm as CGM
      WHERE TB.cgm_usuario = CGM.numcgm
       AND TBL.timestamp_liberado IS NULL AND
                          CASE WHEN tbf.timestamp_fechamento IS NULL
                           THEN
                               TRUE
                           ELSE
                              CASE WHEN TBR.timestamp_reabertura IS NOT NULL
                                  THEN
                                      TBF.timestamp_fechamento < TBR.timestamp_reabertura
                                  ELSE
                                      FALSE
                              END
                           end
         ORDER BY  cod_boletim