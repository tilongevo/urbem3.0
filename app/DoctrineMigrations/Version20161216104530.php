<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para criar a view tesouraria.vw_transferencia
 */
class Version20161216104530 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE OR REPLACE VIEW tesouraria.vw_transferencia AS
              SELECT
                     T.cod_lote,
                     T.exercicio,
                     T.cod_entidade,
                     ent.nom_cgm as nom_entidade,
                     T.tipo,
                     T.cod_boletim,
                     to_char(B.dt_boletim,'yyyy-mm-dd') as dt_boletim,
                     T.cod_historico,
                     to_char(T.timestamp_transferencia,'yyyy-mm-dd') as dt_transferencia,
                     T.timestamp_transferencia,
                     T.observacao,
                     t.cod_plano_credito,
                     credito.nom_conta as nom_conta_credito,
                     t.cod_plano_debito,
                     debito.nom_conta as nom_conta_debito,
                     coalesce(t.valor,0.00) as valor,
                     coalesce(te.valor,0.00) as valor_estornado,
                     ret.cod_recibo_extra as cod_recibo,
                     tr.cod_recurso,
                     tr.masc_recurso_red,
                     tr.nom_recurso,
                     tr.masc_recurso_red || ' - ' || tr.nom_recurso as recurso,
                     tc.cod_credor,
                     tc.nom_credor,
                     t.cod_tipo,
                     HC.nom_historico
                 FROM
                     tesouraria.transferencia as T
                     LEFT JOIN
                         tesouraria.recibo_extra_transferencia as ret
                         on (    ret.exercicio    = t.exercicio
                             AND ret.cod_entidade = t.cod_entidade
                             AND ret.tipo         = t.tipo
                             AND ret.cod_lote     = t.cod_lote )
                     LEFT JOIN
                        ( SELECT
                             tr.cod_recurso,
                             tr.exercicio,
                             tr.tipo,
                             tr.cod_entidade,
                             tr.cod_lote,
                             rec.nom_recurso,
                             rec.masc_recurso_red,
                             rec.cod_detalhamento
                          FROM
                             tesouraria.transferencia_recurso as TR,
                             orcamento.recurso(tr.exercicio)  as REC
                          WHERE
                                 tr.cod_recurso  = rec.cod_recurso
                             AND tr.exercicio     = rec.exercicio
                        ) as TR on (     tr.tipo         = t.tipo
                                     AND tr.exercicio    = t.exercicio
                                     AND tr.cod_entidade = t.cod_entidade
                                     AND tr.cod_lote     = t.cod_lote
                                   )
                     LEFT JOIN
                        ( SELECT
                             tc.numcgm as cod_credor,
                             tc.exercicio,
                             tc.tipo,
                             tc.cod_entidade,
                             tc.cod_lote,
                             cgm.nom_cgm as nom_credor
                          FROM
                             tesouraria.transferencia_credor  as TC,
                             sw_cgm  as CGM
                          WHERE
                                 tc.numcgm    = cgm.numcgm
                        ) as TC on (     tc.tipo         = t.tipo
                                     AND tc.exercicio    = t.exercicio
                                     AND tc.cod_entidade = t.cod_entidade
                                     AND tc.cod_lote     = t.cod_lote
                                   )
                     LEFT JOIN
                         ( SELECT
                              cgm.nom_cgm,
                              e.cod_entidade,
                              e.exercicio
                           FROM
                              sw_cgm as CGM,
                              orcamento.entidade as E
                           WHERE
                              cgm.numcgm = e.numcgm
                         ) as ENT on (
                              ent.exercicio    = t.exercicio    AND
                              ent.cod_entidade = t.cod_entidade
                         )
                     LEFT JOIN tesouraria.boletim as B on (
                             B.cod_boletim  = T.cod_boletim  AND
                             B.exercicio    = T.exercicio    AND
                             B.cod_entidade = T.cod_entidade
                     )
                     LEFT JOIN
                         ( SELECT
                             pc.nom_conta,
                             pa.cod_plano,
                             pa.exercicio
                           FROM
                             contabilidade.plano_conta     as pc,
                             contabilidade.plano_analitica as pa
                           WHERE
                             pa.exercicio = pc.exercicio AND
                             pa.cod_conta = pc.cod_conta
                         ) as debito on (
                                 debito.cod_plano = t.cod_plano_debito AND
                                 debito.exercicio = t.exercicio
                         )
                     LEFT JOIN
                         ( SELECT
                             pc.nom_conta,
                             pa.cod_plano,
                             pa.exercicio
                           FROM
                             contabilidade.plano_conta     as pc,
                             contabilidade.plano_analitica as pa
                           WHERE
                             pa.exercicio = pc.exercicio AND
                             pa.cod_conta = pc.cod_conta
                         ) as credito on (
                                 credito.cod_plano = t.cod_plano_credito AND
                                 credito.exercicio = t.exercicio
                         )
                     LEFT JOIN
                         ( SELECT
                                 coalesce(sum(te.valor),0.00) as valor,
                                 te.cod_lote,
                                 te.cod_entidade,
                                 te.exercicio,
                                 te.tipo
                           FROM tesouraria.transferencia_estornada as te
                           GROUP BY
                                 te.cod_lote,
                                 te.cod_entidade,
                                 te.exercicio,
                                 te.tipo
                         ) as te on (
                                t.cod_lote        = te.cod_lote          AND
                                t.cod_entidade    = te.cod_entidade      AND
                                t.exercicio       = te.exercicio         AND
                                t.tipo            = te.tipo
                         )
                     LEFT JOIN tesouraria.tipo_transferencia as TT on (
                                t.cod_tipo = tt.cod_tipo )
                     LEFT JOIN contabilidade.historico_contabil as HC on (
                                t.cod_historico = HC.cod_historico and
                                t.exercicio     = HC.exercicio)
                ORDER BY t.cod_lote, t.exercicio;
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP VIEW tesouraria.vw_transferencia;");
    }
}
