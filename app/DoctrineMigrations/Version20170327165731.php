<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno;
use Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento;
use Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado;
use Urbem\CoreBundle\Entity\Tesouraria\Pagamento;
use Urbem\CoreBundle\Entity\Tesouraria\VwOrcamentariaPagamentoEstornoView;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170327165731 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamentos;");
        $this->addSql("DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamento_estorno;");
        $this->addSql("DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamentos_registros;");
        $this->addSql("DROP VIEW IF EXISTS orcamento.saldo_dotacao;");
        $this->changeColumnToDateTimeMicrosecondType(PagamentoTipoDocumento::class, 'timestamp');
        $this->addSql("CREATE OR REPLACE VIEW tesouraria.vw_orcamentaria_pagamentos AS
 SELECT tbl.cod_ordem,
    tbl.exercicio,
    tbl.cod_entidade,
    tbl.dt_emissao,
    tbl.dt_vencimento,
    tbl.observacao,
    tbl.entidade,
    tbl.cod_recurso,
    tbl.masc_recurso_red,
    tbl.cod_detalhamento,
    tbl.cgm_beneficiario,
    tbl.implantado,
    tbl.beneficiario,
    tbl.num_exercicio_empenho,
    tbl.exercicio_empenho,
    tbl.dt_estorno,
    tbl.valor_pagamento,
    tbl.valor_anulada,
    tbl.saldo_pagamento,
    tbl.nota_empenho,
    tbl.vl_nota,
    tbl.vl_nota_anulacoes,
    tbl.vl_nota_original,
    tbl.situacao,
    tbl.pagamento_estornado
   FROM ( SELECT tabela.cod_ordem,
            tabela.exercicio,
            tabela.cod_entidade,
            tabela.dt_emissao,
            tabela.dt_vencimento,
            tabela.observacao,
            tabela.entidade,
            tabela.cod_recurso,
            tabela.masc_recurso_red,
            tabela.cod_detalhamento,
            tabela.cgm_beneficiario,
            tabela.implantado,
            tabela.beneficiario,
            sum(tabela.num_exercicio_empenho) AS num_exercicio_empenho,
            tabela.exercicio_empenho,
            ''::text AS dt_estorno,
            COALESCE(sum(tabela.valor_pagamento), 0.00) AS valor_pagamento,
            COALESCE(sum(tabela.valor_anulada), 0.00) AS valor_anulada,
            COALESCE(sum(tabela.saldo_pagamento), 0.00) AS saldo_pagamento,
            tabela.nota_empenho,
            tabela.vl_nota,
            tabela.vl_nota_anulacoes,
            tabela.vl_nota_original,
                CASE
                    WHEN sum(COALESCE(tabela.saldo_pagamento, 0.00)) < COALESCE(tabela.vl_nota, 0.00) AND tabela.vl_nota > 0.00 THEN 'A Pagar'::text
                    WHEN sum(COALESCE(tabela.saldo_pagamento, 0.00)) = COALESCE(tabela.vl_nota, 0.00) AND tabela.vl_nota > 0.00 THEN 'Paga'::text
                    WHEN tabela.vl_nota = 0.00 THEN 'Anulada'::text
                    ELSE NULL::text
                END AS situacao,
                CASE
                    WHEN COALESCE(sum(tabela.valor_anulada), 0.00) > 0.00 THEN 'Sim'::text
                    ELSE 'Não'::text
                END AS pagamento_estornado
           FROM ( SELECT op.cod_ordem,
                    op.exercicio,
                    op.cod_entidade,
                    to_char(op.dt_emissao::timestamp with time zone, 'dd/mm/yyyy'::text) AS dt_emissao,
                    to_char(op.dt_vencimento::timestamp with time zone, 'dd/mm/yyyy'::text) AS dt_vencimento,
                    op.observacao,
                    cgm.nom_cgm AS entidade,
                    1 AS num_exercicio_empenho,
                    em.exercicio AS exercicio_empenho,
                    rec.masc_recurso_red,
                    rec.cod_recurso,
                    rec.cod_detalhamento,
                    pe.cgm_beneficiario,
                    pe.implantado,
                    cgm_pe.nom_cgm AS beneficiario,
                    COALESCE(nota_liq_paga.vl_pago, 0.00) AS valor_pagamento,
                    COALESCE(nota_liq_paga.vl_anulado, 0.00) AS valor_anulada,
                    COALESCE(nota_liq_paga.saldo_pagamento, 0.00) AS saldo_pagamento,
                    nota_liq_paga.cod_nota,
                    empenho.retorna_notas_empenhos(op.exercicio::character varying, op.cod_ordem, op.cod_entidade) AS nota_empenho,
                    sum(COALESCE(tot_op.total_op, 0.00)) AS vl_nota,
                    sum(COALESCE(tot_op.anulacoes_op, 0.00)) AS vl_nota_anulacoes,
                    sum(COALESCE(tot_op.vl_original_op, 0.00)) AS vl_nota_original
                   FROM empenho.ordem_pagamento op
                     LEFT JOIN empenho.ordem_pagamento_anulada opa ON op.cod_ordem = opa.cod_ordem AND op.exercicio::text = opa.exercicio::text AND op.cod_entidade = opa.cod_entidade
                     JOIN empenho.pagamento_liquidacao pl ON op.cod_ordem = pl.cod_ordem AND op.exercicio::text = pl.exercicio::text AND op.cod_entidade = pl.cod_entidade
                     JOIN ( SELECT COALESCE(sum(pl_1.vl_pagamento), 0.00) - COALESCE(opla.vl_anulado, 0.00) AS total_op,
                            COALESCE(opla.vl_anulado, 0.00) AS anulacoes_op,
                            COALESCE(sum(pl_1.vl_pagamento), 0.00) AS vl_original_op,
                            pl_1.cod_ordem,
                            pl_1.cod_entidade,
                            pl_1.exercicio
                           FROM empenho.pagamento_liquidacao pl_1
                             LEFT JOIN ( SELECT opla_1.cod_ordem,
                                    opla_1.cod_entidade,
                                    opla_1.exercicio,
                                    opla_1.exercicio_liquidacao,
                                    opla_1.cod_nota,
                                    COALESCE(sum(opla_1.vl_anulado), 0.00) AS vl_anulado
                                   FROM empenho.ordem_pagamento_liquidacao_anulada opla_1
                                  GROUP BY opla_1.cod_ordem, opla_1.cod_entidade, opla_1.exercicio, opla_1.cod_nota, opla_1.exercicio_liquidacao) opla ON opla.cod_ordem = pl_1.cod_ordem AND opla.cod_entidade = pl_1.cod_entidade AND opla.exercicio::text = pl_1.exercicio::text AND opla.exercicio_liquidacao::text = pl_1.exercicio_liquidacao::text AND opla.cod_nota = pl_1.cod_nota
                          WHERE pl_1.cod_ordem IS NOT NULL
                          GROUP BY pl_1.cod_ordem, pl_1.cod_entidade, pl_1.exercicio, opla.vl_anulado) tot_op ON tot_op.cod_ordem = pl.cod_ordem AND tot_op.exercicio::text = pl.exercicio::text AND tot_op.cod_entidade = pl.cod_entidade
                     JOIN empenho.nota_liquidacao nl ON pl.cod_nota = nl.cod_nota AND pl.cod_entidade = nl.cod_entidade AND pl.exercicio_liquidacao::text = nl.exercicio::text
                     LEFT JOIN ( SELECT nlp.cod_entidade,
                            nlp.cod_nota,
                            plnlp.cod_ordem,
                            plnlp.exercicio,
                            nlp.exercicio AS exercicio_liquidacao,
                            sum(COALESCE(nlp.vl_pago, 0.00)) AS vl_pago,
                            sum(COALESCE(nlpa.vl_anulado, 0.00)) AS vl_anulado,
                            sum(nlp.vl_pago) - COALESCE(nlpa.vl_anulado, 0.00) AS saldo_pagamento
                           FROM empenho.pagamento_liquidacao_nota_liquidacao_paga plnlp,
                            empenho.nota_liquidacao_paga nlp
                             LEFT JOIN ( SELECT nlpa_1.exercicio,
                                    nlpa_1.cod_nota,
                                    nlpa_1.cod_entidade,
                                    nlpa_1.\"timestamp\",
                                    COALESCE(sum(nlpa_1.vl_anulado), 0.00) AS vl_anulado
                                   FROM empenho.nota_liquidacao_paga_anulada nlpa_1
                                  GROUP BY nlpa_1.exercicio, nlpa_1.cod_nota, nlpa_1.cod_entidade, nlpa_1.\"timestamp\") nlpa ON nlp.exercicio::text = nlpa.exercicio::text AND nlp.cod_nota = nlpa.cod_nota AND nlp.cod_entidade = nlpa.cod_entidade AND nlp.\"timestamp\" = nlpa.\"timestamp\"
                          WHERE nlp.cod_entidade = plnlp.cod_entidade AND nlp.cod_nota = plnlp.cod_nota AND nlp.exercicio::text = plnlp.exercicio_liquidacao::text AND nlp.\"timestamp\" = plnlp.\"timestamp\"
                          GROUP BY nlp.cod_entidade, nlp.cod_nota, nlp.exercicio, nlpa.vl_anulado, plnlp.cod_ordem, plnlp.exercicio) nota_liq_paga ON pl.cod_nota = nota_liq_paga.cod_nota AND pl.cod_entidade = nota_liq_paga.cod_entidade AND pl.exercicio::text = nota_liq_paga.exercicio::text AND pl.cod_ordem = nota_liq_paga.cod_ordem AND pl.exercicio_liquidacao::text = nota_liq_paga.exercicio_liquidacao::text
                     JOIN empenho.empenho em ON nl.cod_empenho = em.cod_empenho AND nl.exercicio_empenho::text = em.exercicio::text AND nl.cod_entidade = em.cod_entidade
                     JOIN empenho.pre_empenho pe ON em.exercicio::text = pe.exercicio::text AND em.cod_pre_empenho = pe.cod_pre_empenho
                     JOIN sw_cgm cgm_pe ON pe.cgm_beneficiario = cgm_pe.numcgm
                     LEFT JOIN empenho.pre_empenho_despesa ped ON pe.cod_pre_empenho = ped.cod_pre_empenho AND pe.exercicio::text = ped.exercicio::text
                     LEFT JOIN orcamento.despesa de ON ped.cod_despesa = de.cod_despesa AND ped.exercicio::text = de.exercicio::text
                     LEFT JOIN orcamento.recurso(''::character varying) rec(cod_recurso, exercicio, nom_recurso, tipo, nom_tipo, cod_fonte, masc_recurso, masc_recurso_red, cod_uso, cod_destinacao, cod_especificacao, cod_detalhamento, finalidade) ON de.cod_recurso = rec.cod_recurso AND de.exercicio = rec.exercicio
                     JOIN orcamento.entidade en ON op.cod_entidade = en.cod_entidade AND op.exercicio::text = en.exercicio::text
                     JOIN sw_cgm cgm ON en.numcgm = cgm.numcgm
                  GROUP BY op.cod_ordem, op.exercicio, op.cod_entidade, (to_char(op.dt_emissao::timestamp with time zone, 'dd/mm/yyyy'::text)), (to_char(op.dt_vencimento::timestamp with time zone, 'dd/mm/yyyy'::text)), op.observacao, cgm.nom_cgm, 1::integer, em.exercicio, de.cod_recurso, rec.masc_recurso_red, rec.cod_recurso, rec.cod_detalhamento, pe.cgm_beneficiario, pe.implantado, cgm_pe.nom_cgm, (empenho.retorna_notas_empenhos(op.exercicio::character varying, op.cod_ordem, op.cod_entidade)), pl.exercicio_liquidacao, nota_liq_paga.cod_nota, nota_liq_paga.vl_pago, nota_liq_paga.vl_anulado, nota_liq_paga.saldo_pagamento) tabela
          GROUP BY tabela.cod_ordem, tabela.exercicio, tabela.cod_entidade, tabela.dt_emissao, tabela.dt_vencimento, tabela.observacao, tabela.entidade, tabela.cod_recurso, tabela.masc_recurso_red, tabela.cod_detalhamento, tabela.cgm_beneficiario, tabela.implantado, tabela.beneficiario, ''::text, tabela.nota_empenho, tabela.exercicio_empenho, tabela.vl_nota, tabela.vl_nota_original, tabela.vl_nota_anulacoes) tbl
  WHERE tbl.num_exercicio_empenho > 0;");
        $this->addSql("CREATE OR REPLACE VIEW tesouraria.vw_orcamentaria_pagamento_estorno AS
 SELECT eop.exercicio,
    eop.exercicio AS empenho_pagamento,
    cgm.exercicio_liquidacao,
    cgm.exercicio_empenho,
    eop.cod_entidade,
    eop.cod_empenho,
    eop.cod_nota,
    empenho.retorna_empenhos(eop.exercicio::character varying, eop.cod_ordem, eop.cod_entidade) AS empenho,
    empenho.retorna_notas(eop.exercicio::character varying, eop.cod_ordem, eop.cod_entidade) AS nota,
    (eop.cod_ordem || '/'::text) || eop.exercicio::text AS ordem,
    cgm.nom_cgm AS beneficiario,
    0.00 AS vl_nota,
    COALESCE(eop.vl_pago, 0.00) AS vl_ordem,
    COALESCE(cgm.vl_prestado, 0.00) AS vl_prestado,
    eop.cod_conta,
    eop.nom_conta,
        CASE
            WHEN ordem_pagamento_retencao.cod_ordem IS NOT NULL THEN true
            ELSE false
        END AS retencao
   FROM ( SELECT eplnlp.cod_ordem,
            enlp.cod_entidade,
            enlp.cod_empenho,
            eplnlp.exercicio,
            eplnlp.cod_nota,
            sum(COALESCE(enlp.vl_pago, 0.00)) AS vl_pago,
            enlp.cod_conta,
            enlp.nom_conta
           FROM empenho.pagamento_liquidacao_nota_liquidacao_paga eplnlp
             JOIN ( SELECT tp.exercicio,
                    tp.cod_entidade,
                    tp.cod_nota,
                    tp.\"timestamp\",
                    COALESCE(enlp_1.vl_pago, 0.00) - COALESCE(tpe.vl_anulado, 0.00) AS vl_pago,
                    cpc.cod_conta,
                    cpc.nom_conta,
                    enl.cod_empenho
                   FROM tesouraria.pagamento tp
                     LEFT JOIN ( SELECT enlpa.cod_nota,
                            enlpa.cod_entidade,
                            enlpa.exercicio,
                            enlpa.\"timestamp\",
                            sum(COALESCE(enlpa.vl_anulado, 0.00)) AS vl_anulado
                           FROM tesouraria.pagamento_estornado tpe_1
                             JOIN empenho.nota_liquidacao_paga_anulada enlpa ON enlpa.cod_entidade = tpe_1.cod_entidade AND enlpa.exercicio = tpe_1.exercicio AND enlpa.\"timestamp\" = tpe_1.\"timestamp\" AND enlpa.timestamp_anulada = tpe_1.timestamp_anulado
                          GROUP BY enlpa.cod_nota, enlpa.cod_entidade, enlpa.exercicio, enlpa.\"timestamp\") tpe ON tp.cod_nota = tpe.cod_nota AND tp.cod_entidade = tpe.cod_entidade AND tp.exercicio = tpe.exercicio AND tp.\"timestamp\" = tpe.\"timestamp\"
                     LEFT JOIN contabilidade.plano_analitica cpa ON tp.cod_plano = cpa.cod_plano AND tp.exercicio = cpa.exercicio
                     LEFT JOIN contabilidade.plano_conta cpc ON cpc.exercicio = cpa.exercicio AND cpc.cod_conta = cpa.cod_conta,
                    empenho.nota_liquidacao_paga enlp_1,
                    empenho.nota_liquidacao enl
                  WHERE tp.exercicio = enlp_1.exercicio AND tp.cod_entidade = enlp_1.cod_entidade AND tp.cod_nota = enlp_1.cod_nota AND tp.\"timestamp\" = enlp_1.\"timestamp\" AND enlp_1.exercicio = enl.exercicio AND enlp_1.cod_entidade = enl.cod_entidade AND enlp_1.cod_nota = enl.cod_nota) enlp ON enlp.exercicio = eplnlp.exercicio_liquidacao AND enlp.cod_entidade = eplnlp.cod_entidade AND enlp.cod_nota = eplnlp.cod_nota AND enlp.\"timestamp\" = eplnlp.\"timestamp\"
          WHERE COALESCE(enlp.vl_pago, 0.00) > 0.00
          GROUP BY eplnlp.cod_ordem, enlp.cod_entidade, eplnlp.cod_nota, enlp.cod_empenho, eplnlp.exercicio, enlp.cod_conta, enlp.nom_conta) eop
     LEFT JOIN ( SELECT ordem_pagamento_retencao_1.exercicio,
            ordem_pagamento_retencao_1.cod_entidade,
            ordem_pagamento_retencao_1.cod_ordem
           FROM empenho.ordem_pagamento_retencao ordem_pagamento_retencao_1
          GROUP BY ordem_pagamento_retencao_1.exercicio, ordem_pagamento_retencao_1.cod_entidade, ordem_pagamento_retencao_1.cod_ordem) ordem_pagamento_retencao ON eop.exercicio = ordem_pagamento_retencao.exercicio AND eop.cod_entidade = ordem_pagamento_retencao.cod_entidade AND eop.cod_ordem = ordem_pagamento_retencao.cod_ordem
     JOIN ( SELECT eplnlp.exercicio,
            eplnlp.exercicio_liquidacao,
            ee.exercicio AS exercicio_empenho,
            eplnlp.cod_entidade,
            eplnlp.cod_ordem,
            cgm_1.nom_cgm,
            COALESCE(itens.vl_prestado, 0.00) AS vl_prestado
           FROM empenho.pagamento_liquidacao_nota_liquidacao_paga eplnlp,
            empenho.pagamento_liquidacao epl,
            empenho.nota_liquidacao enl,
            empenho.empenho ee
             LEFT JOIN ( SELECT eipc.cod_empenho,
                    eipc.exercicio,
                    eipc.cod_entidade,
                    COALESCE(sum(eipc.valor_item), 0.00) AS vl_prestado
                   FROM empenho.item_prestacao_contas eipc
                  WHERE NOT (EXISTS ( SELECT item_prestacao_contas_anulado.num_item
                           FROM empenho.item_prestacao_contas_anulado
                          WHERE item_prestacao_contas_anulado.cod_empenho = eipc.cod_empenho AND item_prestacao_contas_anulado.exercicio = eipc.exercicio AND item_prestacao_contas_anulado.cod_entidade = eipc.cod_entidade AND item_prestacao_contas_anulado.num_item = eipc.num_item))
                  GROUP BY eipc.cod_empenho, eipc.exercicio, eipc.cod_entidade) itens ON itens.cod_empenho = ee.cod_empenho AND itens.exercicio = ee.exercicio AND itens.cod_entidade = ee.cod_entidade,
            empenho.pre_empenho epe,
            sw_cgm cgm_1
          WHERE eplnlp.exercicio_liquidacao = epl.exercicio_liquidacao AND eplnlp.cod_entidade = epl.cod_entidade AND eplnlp.cod_ordem = epl.cod_ordem AND eplnlp.exercicio = epl.exercicio AND eplnlp.cod_nota = epl.cod_nota AND epl.exercicio_liquidacao = enl.exercicio AND epl.cod_entidade = enl.cod_entidade AND epl.cod_nota = enl.cod_nota AND enl.exercicio_empenho = ee.exercicio AND enl.cod_entidade = ee.cod_entidade AND enl.cod_empenho = ee.cod_empenho AND ee.exercicio = epe.exercicio AND ee.cod_pre_empenho = epe.cod_pre_empenho AND epe.cgm_beneficiario = cgm_1.numcgm
          GROUP BY eplnlp.exercicio, eplnlp.cod_entidade, eplnlp.cod_ordem, cgm_1.nom_cgm, itens.vl_prestado, eplnlp.exercicio_liquidacao, ee.exercicio
          ORDER BY eplnlp.exercicio, eplnlp.cod_entidade, eplnlp.cod_ordem, cgm_1.nom_cgm) cgm ON cgm.exercicio = eop.exercicio AND cgm.cod_entidade = eop.cod_entidade AND cgm.cod_ordem = eop.cod_ordem;");
        $this->addSql("CREATE OR REPLACE VIEW tesouraria.vw_orcamentaria_pagamentos_registros AS
 SELECT tbl.cod_empenho,
    tbl.ex_empenho,
    tbl.dt_empenho,
    tbl.cod_nota,
    tbl.ex_nota,
    tbl.dt_nota,
    tbl.cod_entidade,
    tbl.vl_pago,
    tbl.vl_pagonaoprestado,
    tbl.vl_prestado,
    tbl.\"timestamp\",
    tbl.dt_pagamento,
    tbl.vl_pagamento,
    tbl.vl_anulado,
    tbl.cod_recurso,
    tbl.cod_plano,
    tbl.exercicio_plano,
    tbl.cod_ordem,
    tbl.exercicio
   FROM ( SELECT eem.cod_empenho,
            eem.exercicio AS ex_empenho,
            to_char(eem.dt_empenho, 'dd/mm/yyyy'::text) AS dt_empenho,
            enl.cod_nota,
            enl.exercicio AS ex_nota,
            to_char(enl.dt_liquidacao::timestamp with time zone, 'dd/mm/yyyy'::text) AS dt_nota,
            enl.cod_entidade,
            COALESCE(sum(pag.vl_pago), 0.00) AS vl_pago,
                CASE
                    WHEN COALESCE(itens.vl_prestado, 0.00) <> 0.00 THEN COALESCE(sum(pag.vl_pago), 0.00) - COALESCE(itens.vl_prestado, 0.00)
                    ELSE COALESCE(sum(pag.vl_pago), 0.00)
                END AS vl_pagonaoprestado,
            COALESCE(itens.vl_prestado, 0.00) AS vl_prestado,
            pag.\"timestamp\",
            to_char(pag.\"timestamp\", 'dd/mm/yyyy'::text) AS dt_pagamento,
            epl.vl_pagamento,
            opla.vl_anulado,
                CASE
                    WHEN ode.cod_recurso IS NOT NULL THEN ode.cod_recurso
                    ELSE rpe.recurso
                END AS cod_recurso,
            pag.cod_plano,
            pag.exercicio_plano,
            epl.cod_ordem,
            epl.exercicio
           FROM empenho.pagamento_liquidacao epl
             LEFT JOIN ( SELECT opla_1.cod_nota,
                    opla_1.exercicio_liquidacao,
                    opla_1.cod_entidade,
                    opla_1.cod_ordem,
                    opla_1.exercicio,
                    sum(opla_1.vl_anulado) AS vl_anulado
                   FROM empenho.ordem_pagamento_liquidacao_anulada opla_1
                  GROUP BY opla_1.cod_nota, opla_1.exercicio_liquidacao, opla_1.cod_entidade, opla_1.cod_ordem, opla_1.exercicio) opla ON opla.cod_nota = epl.cod_nota AND opla.exercicio_liquidacao = epl.exercicio_liquidacao AND opla.cod_entidade = epl.cod_entidade AND opla.cod_ordem = epl.cod_ordem AND opla.exercicio = epl.exercicio
             LEFT JOIN ( SELECT plnlp.exercicio,
                    plnlp.cod_entidade,
                    plnlp.cod_ordem,
                    plnlp.cod_nota,
                    plnlp.\"timestamp\",
                    plnlp.exercicio_liquidacao,
                    COALESCE(sum(tnlp.vl_pago), 0.00) AS vl_pago,
                    tnlp.exercicio_plano,
                    tnlp.cod_plano
                   FROM empenho.pagamento_liquidacao_nota_liquidacao_paga plnlp
                     LEFT JOIN ( SELECT nlp.exercicio,
                            nlp.cod_entidade,
                            nlp.cod_nota,
                            nlp.\"timestamp\",
                            COALESCE(nlp.vl_pago, 0.00) - COALESCE(nlpa.vl_pago_anulado, 0.00) AS vl_pago,
                            nlcp.exercicio AS exercicio_plano,
                            nlcp.cod_plano
                           FROM empenho.nota_liquidacao_paga nlp
                             LEFT JOIN ( SELECT nlpa_1.exercicio,
                                    nlpa_1.cod_nota,
                                    nlpa_1.cod_entidade,
                                    nlpa_1.\"timestamp\",
                                    COALESCE(sum(nlpa_1.vl_anulado), 0.00) AS vl_pago_anulado
                                   FROM empenho.nota_liquidacao_paga_anulada nlpa_1
                                  GROUP BY nlpa_1.exercicio, nlpa_1.cod_nota, nlpa_1.cod_entidade, nlpa_1.\"timestamp\") nlpa ON nlpa.exercicio = nlp.exercicio AND nlpa.cod_nota = nlp.cod_nota AND nlpa.cod_entidade = nlp.cod_entidade AND nlpa.\"timestamp\" = nlp.\"timestamp\"
                             LEFT JOIN empenho.nota_liquidacao_conta_pagadora nlcp ON nlcp.exercicio_liquidacao = nlp.exercicio AND nlcp.cod_entidade = nlp.cod_entidade AND nlcp.cod_nota = nlp.cod_nota AND nlcp.\"timestamp\" = nlp.\"timestamp\") tnlp ON tnlp.exercicio = plnlp.exercicio_liquidacao AND tnlp.cod_nota = plnlp.cod_nota AND tnlp.cod_entidade = plnlp.cod_entidade AND tnlp.\"timestamp\" = plnlp.\"timestamp\"
                  GROUP BY plnlp.exercicio, plnlp.cod_entidade, plnlp.cod_ordem, plnlp.cod_nota, plnlp.\"timestamp\", plnlp.exercicio_liquidacao, tnlp.exercicio_plano, tnlp.cod_plano) pag ON pag.exercicio = epl.exercicio AND pag.cod_entidade = epl.cod_entidade AND pag.cod_ordem = epl.cod_ordem AND pag.cod_nota = epl.cod_nota AND pag.exercicio_liquidacao = epl.exercicio_liquidacao
             JOIN empenho.nota_liquidacao enl ON epl.exercicio_liquidacao = enl.exercicio AND epl.cod_nota = enl.cod_nota AND epl.cod_entidade = enl.cod_entidade
             JOIN empenho.empenho eem ON enl.exercicio_empenho = eem.exercicio AND enl.cod_entidade = eem.cod_entidade AND enl.cod_empenho = eem.cod_empenho
             LEFT JOIN ( SELECT eipc.cod_empenho,
                    eipc.exercicio,
                    eipc.cod_entidade,
                    COALESCE(sum(eipc.valor_item), 0.00) AS vl_prestado
                   FROM empenho.item_prestacao_contas eipc
                  WHERE NOT (EXISTS ( SELECT item_prestacao_contas_anulado.num_item
                           FROM empenho.item_prestacao_contas_anulado
                          WHERE item_prestacao_contas_anulado.cod_empenho = eipc.cod_empenho AND item_prestacao_contas_anulado.exercicio = eipc.exercicio AND item_prestacao_contas_anulado.cod_entidade = eipc.cod_entidade AND item_prestacao_contas_anulado.num_item = eipc.num_item))
                  GROUP BY eipc.cod_empenho, eipc.exercicio, eipc.cod_entidade) itens ON itens.cod_empenho = eem.cod_empenho AND itens.exercicio = eem.exercicio AND itens.cod_entidade = eem.cod_entidade
             JOIN empenho.pre_empenho epe ON eem.exercicio = epe.exercicio AND eem.cod_pre_empenho = epe.cod_pre_empenho
             LEFT JOIN empenho.pre_empenho_despesa epd ON epe.exercicio = epd.exercicio AND epe.cod_pre_empenho = epd.cod_pre_empenho
             LEFT JOIN orcamento.despesa ode ON epd.exercicio = ode.exercicio AND epd.cod_despesa = ode.cod_despesa
             LEFT JOIN empenho.restos_pre_empenho rpe ON epe.exercicio = rpe.exercicio AND epe.cod_pre_empenho = rpe.cod_pre_empenho
          GROUP BY eem.cod_empenho, eem.exercicio, (to_char(eem.dt_empenho, 'dd/mm/yyyy'::text)), enl.cod_nota, enl.exercicio, (to_char(enl.dt_liquidacao::timestamp with time zone, 'dd/mm/yyyy'::text)), enl.cod_entidade, epl.vl_pagamento, itens.vl_prestado, opla.vl_anulado, pag.\"timestamp\", ode.cod_recurso, rpe.recurso, pag.exercicio_plano, pag.cod_plano, epl.cod_ordem, epl.exercicio
          ORDER BY enl.cod_nota) tbl
  WHERE tbl.vl_pago = 0::numeric;");
        $this->addSql("CREATE OR REPLACE VIEW orcamento.saldo_dotacao AS
 SELECT tabela.cod_entidade,
    tabela.exercicio,
    tabela.entidade,
    tabela.cod_despesa,
    tabela.cod_conta,
    tabela.descricao,
    tabela.num_orgao,
    tabela.nom_orgao,
    tabela.num_unidade,
    tabela.nom_unidade,
    tabela.cod_funcao,
    tabela.funcao,
    tabela.cod_subfuncao,
    tabela.subfuncao,
    tabela.cod_programa,
    tabela.num_programa,
    tabela.programa,
    tabela.num_pao,
    tabela.num_acao,
    tabela.nom_pao,
    tabela.cod_estrutural,
    tabela.cod_recurso,
    tabela.nom_recurso,
    tabela.cod_fonte,
    tabela.masc_recurso_red,
    tabela.cod_detalhamento,
    tabela.valor_orcado,
    tabela.valor_suplementado,
    tabela.valor_reduzido,
    tabela.valor_reserva,
    tabela.valor_empenhado,
    tabela.valor_anulado,
    tabela.valor_liquidado,
    tabela.valor_pago,
    tabela.valor_orcado + tabela.valor_suplementado - tabela.valor_reduzido - tabela.valor_empenhado + tabela.valor_anulado - tabela.valor_reserva AS saldo_disponivel,
    tabela.valor_orcado - tabela.valor_reserva AS saldo,
    row_number() OVER () AS rnum
   FROM ( SELECT d.cod_entidade,
            d.exercicio,
            cgm.nom_cgm AS entidade,
            d.cod_despesa,
            cd.cod_conta,
            cd.descricao,
            d.num_orgao,
            oo.nom_orgao,
            d.num_unidade,
            ou.nom_unidade,
            d.cod_funcao,
            f.descricao AS funcao,
            d.cod_subfuncao,
            sf.descricao AS subfuncao,
            d.cod_programa,
            programa.num_programa,
            p.descricao AS programa,
            d.num_pao,
            acao.num_acao,
            pao.nom_pao,
            cd.cod_estrutural,
            d.cod_recurso,
            r.nom_recurso,
            r.cod_fonte,
            r.masc_recurso_red,
            r.cod_detalhamento,
            COALESCE(sum(d.vl_original), 0.00) AS valor_orcado,
            COALESCE(sum(ss.valor), 0.00) AS valor_suplementado,
            COALESCE(sum(sr.valor), 0.00) AS valor_reduzido,
            COALESCE(sum(rs.vl_reserva), 0.00) AS valor_reserva,
            COALESCE(sum(emp.vl_empenhado), 0.00) AS valor_empenhado,
            COALESCE(sum(emp.vl_anulado), 0.00) AS valor_anulado,
            COALESCE(sum(emp.vl_liquidado), 0.00) AS valor_liquidado,
            COALESCE(sum(emp.vl_pago), 0.00) AS valor_pago
           FROM orcamento.despesa d
             LEFT JOIN ( SELECT ssup.cod_despesa,
                    ssup.exercicio,
                    COALESCE(sum(ssup.valor), 0.00) AS valor
                   FROM orcamento.suplementacao_suplementada ssup,
                    orcamento.suplementacao s
                  WHERE ssup.cod_suplementacao = s.cod_suplementacao AND ssup.exercicio = s.exercicio AND s.cod_tipo <> 16 AND (( SELECT sa.cod_suplementacao
                           FROM orcamento.suplementacao_anulada sa
                          WHERE sa.exercicio = s.exercicio AND sa.cod_suplementacao = s.cod_suplementacao)) IS NULL
                  GROUP BY ssup.cod_despesa, ssup.exercicio) ss ON d.cod_despesa = ss.cod_despesa AND d.exercicio = ss.exercicio
             LEFT JOIN ( SELECT sred.cod_despesa,
                    sred.exercicio,
                    COALESCE(sum(sred.valor), 0.00) AS valor
                   FROM orcamento.suplementacao_reducao sred,
                    orcamento.suplementacao s
                  WHERE sred.cod_suplementacao = s.cod_suplementacao AND sred.exercicio = s.exercicio AND s.cod_tipo <> 16 AND (( SELECT sa.cod_suplementacao
                           FROM orcamento.suplementacao_anulada sa
                          WHERE sa.exercicio = s.exercicio AND sa.cod_suplementacao = s.cod_suplementacao)) IS NULL
                  GROUP BY sred.cod_despesa, sred.exercicio) sr ON d.cod_despesa = sr.cod_despesa AND d.exercicio = sr.exercicio
             LEFT JOIN ( SELECT r_1.cod_despesa,
                    r_1.exercicio,
                    COALESCE(sum(r_1.vl_reserva), 0.00) AS vl_reserva
                   FROM orcamento.reserva_saldos r_1
                  WHERE NOT (EXISTS ( SELECT 1
                           FROM orcamento.reserva_saldos_anulada orsa
                          WHERE orsa.cod_reserva = r_1.cod_reserva AND orsa.exercicio = r_1.exercicio)) AND r_1.dt_validade_final > to_date(now()::character varying::text, 'yyyy-mm-dd'::text)
                  GROUP BY r_1.cod_despesa, r_1.exercicio) rs ON d.cod_despesa = rs.cod_despesa AND d.exercicio = rs.exercicio
             LEFT JOIN ( SELECT pd.cod_despesa,
                    pd.exercicio,
                    ee.cod_entidade,
                    COALESCE(sum(emp_1.valor), 0.00) AS vl_empenhado,
                    COALESCE(sum(anu.valor), 0.00) AS vl_anulado,
                    COALESCE(sum(nl.vl_liquidado), 0.00) - COALESCE(sum(nl.vl_liquidado_anulado), 0.00) AS vl_liquidado,
                    COALESCE(sum(nl.vl_pago), 0.00) - COALESCE(sum(nl.vl_estornado), 0.00) AS vl_pago
                   FROM empenho.empenho ee
                     LEFT JOIN ( SELECT pe_1.exercicio,
                            pe_1.cod_pre_empenho,
                            COALESCE(sum(ie.vl_total), 0.00) AS valor
                           FROM empenho.empenho e_1,
                            empenho.pre_empenho pe_1,
                            empenho.item_pre_empenho ie
                          WHERE e_1.cod_pre_empenho = pe_1.cod_pre_empenho AND e_1.exercicio = pe_1.exercicio AND ie.cod_pre_empenho = pe_1.cod_pre_empenho AND ie.exercicio = pe_1.exercicio
                          GROUP BY pe_1.exercicio, pe_1.cod_pre_empenho) emp_1 ON emp_1.exercicio = ee.exercicio AND emp_1.cod_pre_empenho = ee.cod_pre_empenho
                     LEFT JOIN ( SELECT ea.exercicio,
                            ea.cod_empenho,
                            ea.cod_entidade,
                            COALESCE(sum(eai.vl_anulado), 0.00) AS valor
                           FROM empenho.empenho_anulado ea,
                            empenho.empenho_anulado_item eai
                          WHERE ea.exercicio = eai.exercicio AND ea.cod_entidade = eai.cod_entidade AND ea.cod_empenho = eai.cod_empenho AND ea.\"timestamp\" = eai.\"timestamp\"
                          GROUP BY ea.exercicio, ea.cod_empenho, ea.cod_entidade) anu ON anu.exercicio = ee.exercicio AND anu.cod_empenho = ee.cod_empenho AND anu.cod_entidade = ee.cod_entidade
                     LEFT JOIN ( SELECT nl_1.exercicio,
                            nl_1.cod_empenho,
                            nl_1.cod_entidade,
                            sum(nli.vl_total) AS vl_liquidado,
                            sum(nlia.valor) AS vl_liquidado_anulado,
                            sum(nlp.vl_pago) AS vl_pago,
                            sum(nlpa.vl_estornado) AS vl_estornado
                           FROM empenho.nota_liquidacao nl_1
                             LEFT JOIN ( SELECT nota_liquidacao_item.exercicio,
                                    nota_liquidacao_item.cod_nota,
                                    nota_liquidacao_item.cod_entidade,
                                    COALESCE(sum(nota_liquidacao_item.vl_total), 0.00) AS vl_total
                                   FROM empenho.nota_liquidacao_item
                                  GROUP BY nota_liquidacao_item.exercicio, nota_liquidacao_item.cod_nota, nota_liquidacao_item.cod_entidade) nli ON nl_1.exercicio = nli.exercicio AND nl_1.cod_nota = nli.cod_nota AND nl_1.cod_entidade = nli.cod_entidade
                             LEFT JOIN ( SELECT nli_1.exercicio,
                                    nli_1.cod_nota,
                                    nli_1.cod_entidade,
                                    COALESCE(sum(nlia_1.vl_anulado), 0.00) AS valor
                                   FROM empenho.nota_liquidacao_item nli_1,
                                    empenho.nota_liquidacao_item_anulado nlia_1
                                  WHERE nli_1.exercicio = nlia_1.exercicio AND nli_1.cod_nota = nlia_1.cod_nota AND nli_1.num_item = nlia_1.num_item AND nli_1.exercicio_item = nlia_1.exercicio_item AND nli_1.cod_pre_empenho = nlia_1.cod_pre_empenho AND nli_1.cod_entidade = nlia_1.cod_entidade
                                  GROUP BY nli_1.exercicio, nli_1.cod_nota, nli_1.cod_entidade) nlia ON nl_1.exercicio = nlia.exercicio AND nl_1.cod_nota = nlia.cod_nota AND nl_1.cod_entidade = nlia.cod_entidade
                             LEFT JOIN ( SELECT COALESCE(sum(nlp_1.vl_pago), 0.00) AS vl_pago,
                                    nlp_1.exercicio,
                                    nlp_1.cod_entidade,
                                    nlp_1.cod_nota
                                   FROM empenho.nota_liquidacao_paga nlp_1
                                  GROUP BY nlp_1.exercicio, nlp_1.cod_entidade, nlp_1.cod_nota) nlp ON nl_1.exercicio = nlp.exercicio AND nl_1.cod_nota = nlp.cod_nota AND nl_1.cod_entidade = nlp.cod_entidade
                             LEFT JOIN ( SELECT nlp_1.exercicio,
                                    nlp_1.cod_nota,
                                    nlp_1.cod_entidade,
                                    COALESCE(sum(nlpa_1.vl_anulado), 0.00) AS vl_estornado
                                   FROM empenho.nota_liquidacao_paga nlp_1,
                                    empenho.nota_liquidacao_paga_anulada nlpa_1
                                  WHERE nlp_1.exercicio = nlpa_1.exercicio AND nlp_1.cod_nota = nlpa_1.cod_nota AND nlp_1.cod_entidade = nlpa_1.cod_entidade AND nlp_1.\"timestamp\" = nlpa_1.\"timestamp\"
                                  GROUP BY nlp_1.exercicio, nlp_1.cod_nota, nlp_1.cod_entidade) nlpa ON nl_1.exercicio = nlpa.exercicio AND nl_1.cod_nota = nlpa.cod_nota AND nl_1.cod_entidade = nlpa.cod_entidade
                          GROUP BY nl_1.exercicio, nl_1.cod_empenho, nl_1.cod_entidade) nl ON nl.exercicio = ee.exercicio AND nl.cod_empenho = ee.cod_empenho AND nl.cod_entidade = ee.cod_entidade,
                    empenho.pre_empenho pe,
                    empenho.pre_empenho_despesa pd
                  WHERE ee.cod_pre_empenho = pe.cod_pre_empenho AND ee.exercicio = pe.exercicio AND pd.cod_pre_empenho = pe.cod_pre_empenho AND pd.exercicio = pe.exercicio
                  GROUP BY pd.cod_despesa, pd.exercicio, ee.cod_entidade) emp ON d.cod_despesa = emp.cod_despesa AND d.exercicio = emp.exercicio AND d.cod_entidade = emp.cod_entidade
             JOIN orcamento.programa_ppa_programa ON programa_ppa_programa.cod_programa = d.cod_programa AND programa_ppa_programa.exercicio = d.exercicio
             JOIN ppa.programa ON programa.cod_programa = programa_ppa_programa.cod_programa_ppa
             JOIN orcamento.pao_ppa_acao ON pao_ppa_acao.num_pao = d.num_pao AND pao_ppa_acao.exercicio = d.exercicio
             JOIN ppa.acao ON acao.cod_acao = pao_ppa_acao.cod_acao,
            orcamento.conta_despesa cd,
            orcamento.entidade e,
            sw_cgm cgm,
            orcamento.orgao oo,
            orcamento.unidade ou,
            orcamento.funcao f,
            orcamento.subfuncao sf,
            orcamento.programa p,
            orcamento.pao pao,
            LATERAL orcamento.recurso(d.exercicio::character varying) r(cod_recurso, exercicio, nom_recurso, tipo, nom_tipo, cod_fonte, masc_recurso, masc_recurso_red, cod_uso, cod_destinacao, cod_especificacao, cod_detalhamento, finalidade)
          WHERE d.cod_conta = cd.cod_conta AND d.exercicio = cd.exercicio AND d.exercicio = ou.exercicio AND d.num_unidade = ou.num_unidade AND d.num_orgao = ou.num_orgao AND d.exercicio = e.exercicio AND d.cod_entidade = e.cod_entidade AND e.numcgm = cgm.numcgm AND ou.exercicio = oo.exercicio AND ou.num_orgao = oo.num_orgao AND d.exercicio = f.exercicio AND d.cod_funcao = f.cod_funcao AND d.exercicio = sf.exercicio AND d.cod_subfuncao = sf.cod_subfuncao AND d.exercicio = p.exercicio AND d.cod_programa = p.cod_programa AND d.exercicio = pao.exercicio AND d.num_pao = pao.num_pao AND d.exercicio = r.exercicio AND d.cod_recurso = r.cod_recurso
          GROUP BY d.cod_entidade, d.exercicio, cgm.nom_cgm, d.cod_despesa, cd.cod_conta, cd.descricao, d.num_orgao, oo.nom_orgao, ou.nom_unidade, d.num_unidade, d.cod_funcao, f.descricao, d.cod_subfuncao, sf.descricao, d.cod_programa, programa.num_programa, p.descricao, d.num_pao, acao.num_acao, pao.nom_pao, cd.cod_estrutural, d.cod_recurso, r.nom_recurso, r.masc_recurso, r.cod_fonte, r.masc_recurso_red, r.cod_detalhamento
          ORDER BY d.cod_entidade, d.cod_despesa) tabela;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
