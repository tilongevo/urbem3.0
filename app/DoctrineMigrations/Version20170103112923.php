<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra;
use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAnulacao;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;
use Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170103112923 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP VIEW IF EXISTS tesouraria.vw_recibo_extra;");
        $this->changeColumnToDateTimeMicrosecondType(ReciboExtra::class, 'timestamp');
        $this->addSql("
            create
                or replace view tesouraria.vw_recibo_extra as select
                    re.cod_recibo_extra,
                    re.exercicio,
                    re.cod_entidade,
                    re.tipo_recibo,
                    re.cod_plano as cod_plano_receita,
                    reb.cod_plano as cod_plano_banco,
                    rer.cod_recurso as cod_recurso,
                    ore.masc_recurso as masc_recurso,
                    rec.numcgm as cod_credor,
                    re.valor,
                    to_char(
                        re.timestamp,
                        'dd/mm/yyyy'
                    ) as dt_recibo,
                    pc.nom_conta
                from
                    tesouraria.recibo_extra re inner join contabilidade.plano_analitica as pa on
                    (
                        pa.cod_plano = re.cod_plano
                        and pa.exercicio = re.exercicio
                    ) inner join contabilidade.plano_conta as pc on
                    (
                        pc.exercicio = pa.exercicio
                        and pc.cod_conta = pa.cod_conta
                    ) left join tesouraria.recibo_extra_banco as reb on
                    (
                        reb.cod_recibo_extra = re.cod_recibo_extra
                        and reb.exercicio = re.exercicio
                        and reb.cod_entidade = re.cod_entidade
                        and reb.tipo_recibo = re.tipo_recibo
                    ) left join tesouraria.recibo_extra_credor as rec on
                    (
                        rec.cod_recibo_extra = re.cod_recibo_extra
                        and rec.exercicio = re.exercicio
                        and rec.cod_entidade = re.cod_entidade
                        and rec.tipo_recibo = re.tipo_recibo
                    ) left join tesouraria.recibo_extra_recurso as rer on
                    (
                        rer.cod_recibo_extra = re.cod_recibo_extra
                        and rer.exercicio = re.exercicio
                        and rer.cod_entidade = re.cod_entidade
                        and rer.tipo_recibo = re.tipo_recibo
                    ) left join orcamento.recurso(rer.exercicio) as ore on
                    (
                        ore.cod_recurso = rer.cod_recurso
                        and ore.exercicio = rer.exercicio
                    ) left join tesouraria.recibo_extra_anulacao rea on
                    (
                        re.cod_recibo_extra = rea.cod_recibo_extra
                        and re.exercicio = rea.exercicio
                        and re.cod_entidade = rea.cod_entidade
                        and re.tipo_recibo = rea.tipo_recibo
                    )
                where
                    rea.cod_recibo_extra is null
                    and not exists(
                        select
                            1
                        from
                            tesouraria.recibo_extra_transferencia inner join(
                                select
                                    (
                                        sum( valor )- sum( coalesce( transferencia_estornada.vl_estornado, 0 ))
                                    ) as vl_saldo,
                                    transferencia.cod_lote,
                                    transferencia.cod_entidade,
                                    transferencia.tipo,
                                    transferencia.exercicio
                                from
                                    tesouraria.transferencia left join(
                                        select
                                            sum( valor ) as vl_estornado,
                                            transferencia_estornada.cod_lote,
                                            transferencia_estornada.cod_entidade,
                                            transferencia_estornada.tipo,
                                            transferencia_estornada.exercicio
                                        from
                                            tesouraria.transferencia_estornada
                                        group by
                                            transferencia_estornada.cod_lote,
                                            transferencia_estornada.cod_entidade,
                                            transferencia_estornada.tipo,
                                            transferencia_estornada.exercicio
                                    ) as transferencia_estornada on
                                    transferencia_estornada.cod_lote = transferencia.cod_lote
                                    and transferencia_estornada.cod_entidade = transferencia.cod_entidade
                                    and transferencia_estornada.tipo = transferencia.tipo
                                    and transferencia_estornada.exercicio = transferencia.exercicio
                                group by
                                    transferencia.cod_lote,
                                    transferencia.cod_entidade,
                                    transferencia.tipo,
                                    transferencia.exercicio
                            ) as transferencia on
                            transferencia.cod_lote = recibo_extra_transferencia.cod_lote
                            and transferencia.cod_entidade = recibo_extra_transferencia.cod_entidade
                            and transferencia.tipo = recibo_extra_transferencia.tipo
                            and transferencia.cod_lote = recibo_extra_transferencia.cod_lote
                        where
                            recibo_extra_transferencia.cod_recibo_extra = re.cod_recibo_extra
                            and recibo_extra_transferencia.exercicio = re.exercicio
                            and recibo_extra_transferencia.cod_entidade = re.cod_entidade
                            and recibo_extra_transferencia.tipo_recibo = re.tipo_recibo
                            and transferencia.vl_saldo > 0
                    )
        ");
        $this->changeColumnToDateTimeMicrosecondType(ReciboExtraAnulacao::class, 'timestamp_anulacao');

        $this->addSql("DROP VIEW IF EXISTS tesouraria.vw_transferencia;");
        $this->changeColumnToDateTimeMicrosecondType(Transferencia::class, 'timestamp_transferencia');
        $this->addSql("
            create
                or replace view tesouraria.vw_transferencia as select
                    T.cod_lote,
                    T.exercicio,
                    T.cod_entidade,
                    ent.nom_cgm as nom_entidade,
                    T.tipo,
                    T.cod_boletim,
                    to_char(
                        B.dt_boletim,
                        'yyyy-mm-dd'
                    ) as dt_boletim,
                    T.cod_historico,
                    to_char(
                        T.timestamp_transferencia,
                        'yyyy-mm-dd'
                    ) as dt_transferencia,
                    T.timestamp_transferencia,
                    T.observacao,
                    t.cod_plano_credito,
                    credito.nom_conta as nom_conta_credito,
                    t.cod_plano_debito,
                    debito.nom_conta as nom_conta_debito,
                    coalesce(
                        t.valor,
                        0.00
                    ) as valor,
                    coalesce(
                        te.valor,
                        0.00
                    ) as valor_estornado,
                    ret.cod_recibo_extra as cod_recibo,
                    tr.cod_recurso,
                    tr.masc_recurso_red,
                    tr.nom_recurso,
                    tr.masc_recurso_red || ' - ' || tr.nom_recurso as recurso,
                    tc.cod_credor,
                    tc.nom_credor,
                    t.cod_tipo,
                    HC.nom_historico
                from
                    tesouraria.transferencia as T left join tesouraria.recibo_extra_transferencia as ret on
                    (
                        ret.exercicio = t.exercicio
                        and ret.cod_entidade = t.cod_entidade
                        and ret.tipo = t.tipo
                        and ret.cod_lote = t.cod_lote
                    ) left join(
                        select
                            tr.cod_recurso,
                            tr.exercicio,
                            tr.tipo,
                            tr.cod_entidade,
                            tr.cod_lote,
                            rec.nom_recurso,
                            rec.masc_recurso_red,
                            rec.cod_detalhamento
                        from
                            tesouraria.transferencia_recurso as TR,
                            orcamento.recurso(tr.exercicio) as REC
                        where
                            tr.cod_recurso = rec.cod_recurso
                            and tr.exercicio = rec.exercicio
                    ) as TR on
                    (
                        tr.tipo = t.tipo
                        and tr.exercicio = t.exercicio
                        and tr.cod_entidade = t.cod_entidade
                        and tr.cod_lote = t.cod_lote
                    ) left join(
                        select
                            tc.numcgm as cod_credor,
                            tc.exercicio,
                            tc.tipo,
                            tc.cod_entidade,
                            tc.cod_lote,
                            cgm.nom_cgm as nom_credor
                        from
                            tesouraria.transferencia_credor as TC,
                            sw_cgm as CGM
                        where
                            tc.numcgm = cgm.numcgm
                    ) as TC on
                    (
                        tc.tipo = t.tipo
                        and tc.exercicio = t.exercicio
                        and tc.cod_entidade = t.cod_entidade
                        and tc.cod_lote = t.cod_lote
                    ) left join(
                        select
                            cgm.nom_cgm,
                            e.cod_entidade,
                            e.exercicio
                        from
                            sw_cgm as CGM,
                            orcamento.entidade as E
                        where
                            cgm.numcgm = e.numcgm
                    ) as ENT on
                    (
                        ent.exercicio = t.exercicio
                        and ent.cod_entidade = t.cod_entidade
                    ) left join tesouraria.boletim as B on
                    (
                        B.cod_boletim = T.cod_boletim
                        and B.exercicio = T.exercicio
                        and B.cod_entidade = T.cod_entidade
                    ) left join(
                        select
                            pc.nom_conta,
                            pa.cod_plano,
                            pa.exercicio
                        from
                            contabilidade.plano_conta as pc,
                            contabilidade.plano_analitica as pa
                        where
                            pa.exercicio = pc.exercicio
                            and pa.cod_conta = pc.cod_conta
                    ) as debito on
                    (
                        debito.cod_plano = t.cod_plano_debito
                        and debito.exercicio = t.exercicio
                    ) left join(
                        select
                            pc.nom_conta,
                            pa.cod_plano,
                            pa.exercicio
                        from
                            contabilidade.plano_conta as pc,
                            contabilidade.plano_analitica as pa
                        where
                            pa.exercicio = pc.exercicio
                            and pa.cod_conta = pc.cod_conta
                    ) as credito on
                    (
                        credito.cod_plano = t.cod_plano_credito
                        and credito.exercicio = t.exercicio
                    ) left join(
                        select
                            coalesce(
                                sum( te.valor ),
                                0.00
                            ) as valor,
                            te.cod_lote,
                            te.cod_entidade,
                            te.exercicio,
                            te.tipo
                        from
                            tesouraria.transferencia_estornada as te
                        group by
                            te.cod_lote,
                            te.cod_entidade,
                            te.exercicio,
                            te.tipo
                    ) as te on
                    (
                        t.cod_lote = te.cod_lote
                        and t.cod_entidade = te.cod_entidade
                        and t.exercicio = te.exercicio
                        and t.tipo = te.tipo
                    ) left join tesouraria.tipo_transferencia as TT on
                    (
                        t.cod_tipo = tt.cod_tipo
                    ) left join contabilidade.historico_contabil as HC on
                    (
                        t.cod_historico = HC.cod_historico
                        and t.exercicio = HC.exercicio
                    )
                order by
                    t.cod_lote,
                    t.exercicio;
        ");
        $this->changeColumnToDateTimeMicrosecondType(TransferenciaEstornada::class, 'timestamp_estornada');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
