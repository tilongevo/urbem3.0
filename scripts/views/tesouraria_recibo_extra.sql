CREATE OR REPLACE VIEW tesouraria.vw_recibo_extra AS
          SELECT
                re.cod_recibo_extra
               ,re.exercicio
               ,re.cod_entidade
               ,re.tipo_recibo
               ,re.cod_plano       as cod_plano_receita
               ,reb.cod_plano      as cod_plano_banco
               ,rer.cod_recurso    as cod_recurso
               ,ore.masc_recurso   as masc_recurso
               ,rec.numcgm         as cod_credor
               ,re.valor
               ,to_char(re.timestamp,'dd/mm/yyyy') as dt_recibo
               ,pc.nom_conta
           FROM
               tesouraria.recibo_extra re
               inner join contabilidade.plano_analitica as pa on(
                   pa.cod_plano = re.cod_plano
               and pa.exercicio = re.exercicio )
               inner join contabilidade.plano_conta as pc on(
                   pc.exercicio = pa.exercicio
               and pc.cod_conta = pa.cod_conta  )
               left join tesouraria.recibo_extra_banco as reb      ON (
                           reb.cod_recibo_extra =  re.cod_recibo_extra
                       AND reb.exercicio        =  re.exercicio
                       AND reb.cod_entidade     =  re.cod_entidade
                       AND reb.tipo_recibo      =  re.tipo_recibo
               )
               left join tesouraria.recibo_extra_credor as rec     ON (
                           rec.cod_recibo_extra =  re.cod_recibo_extra
                       AND rec.exercicio        =  re.exercicio
                       AND rec.cod_entidade     =  re.cod_entidade
                       AND rec.tipo_recibo      =  re.tipo_recibo
               )
               left join tesouraria.recibo_extra_recurso as rer    ON (
                           rer.cod_recibo_extra =  re.cod_recibo_extra
                       AND rer.exercicio        =  re.exercicio
                       AND rer.cod_entidade     =  re.cod_entidade
                       AND rer.tipo_recibo      =  re.tipo_recibo
               )
               left join orcamento.recurso(rer.exercicio) as ore
                    ON ( ore.cod_recurso = rer.cod_recurso
                     AND ore.exercicio   = rer.exercicio )
               left join tesouraria.recibo_extra_anulacao rea      ON (
                           re.cod_recibo_extra  = rea.cod_recibo_extra
                       AND re.exercicio         = rea.exercicio
                       AND re.cod_entidade      = rea.cod_entidade
                       AND re.tipo_recibo      =  rea.tipo_recibo
               )
           WHERE rea.cod_recibo_extra     is     null
             AND NOT EXISTS ( SELECT 1
                           FROM tesouraria.recibo_extra_transferencia
                     INNER JOIN ( SELECT (SUM(valor) - SUM(COALESCE(transferencia_estornada.vl_estornado,0))) AS vl_saldo
                                       , transferencia.cod_lote
                                       , transferencia.cod_entidade
                                       , transferencia.tipo
                                       , transferencia.exercicio
                                    FROM tesouraria.transferencia
                               LEFT JOIN ( SELECT SUM(valor) AS vl_estornado
                                                , transferencia_estornada.cod_lote
                                                , transferencia_estornada.cod_entidade
                                                , transferencia_estornada.tipo
                                                , transferencia_estornada.exercicio
                                             FROM tesouraria.transferencia_estornada
                                         GROUP BY  transferencia_estornada.cod_lote
                                                , transferencia_estornada.cod_entidade
                                                , transferencia_estornada.tipo
                                                , transferencia_estornada.exercicio
                                         ) AS transferencia_estornada
                                      ON transferencia_estornada.cod_lote     = transferencia.cod_lote
                                     AND transferencia_estornada.cod_entidade = transferencia.cod_entidade
                                     AND transferencia_estornada.tipo         = transferencia.tipo
                                     AND transferencia_estornada.exercicio    = transferencia.exercicio
                                GROUP BY transferencia.cod_lote
                                       , transferencia.cod_entidade
                                       , transferencia.tipo
                                       , transferencia.exercicio
                                ) AS transferencia
                             ON transferencia.cod_lote     = recibo_extra_transferencia.cod_lote
                            AND transferencia.cod_entidade = recibo_extra_transferencia.cod_entidade
                            AND transferencia.tipo         = recibo_extra_transferencia.tipo
                            AND transferencia.cod_lote     = recibo_extra_transferencia.cod_lote
                          WHERE recibo_extra_transferencia.cod_recibo_extra = re.cod_recibo_extra
                            AND recibo_extra_transferencia.exercicio        = re.exercicio
                            AND recibo_extra_transferencia.cod_entidade     = re.cod_entidade
                            AND recibo_extra_transferencia.tipo_recibo      = re.tipo_recibo
                            AND transferencia.vl_saldo > 0
                       )