<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170329092515 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamento_estorno;');
        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamentos_estorno_registros;');
        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamentos;');
        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamentos_registros');
        $this->addSql('DROP VIEW IF EXISTS orcamento.saldo_dotacao;');
        $this->changeColumnToDateTimeMicrosecondType(PagamentoTipoDocumento::class, 'timestamp');
        $this->createViewOrcamentariaPagamentoEstorno();
        $this->createViewOrcamentariaPagamentosEstornoRegistros();
        $this->createViewOrcamentariaPagamentos();
        $this->createViewOrcamentariaPagamentosRegistros();
        $this->createViewSaldoDotacao();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamento_estorno;');
        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamentos_estorno_registros;');
        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamentos;');
        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_orcamentaria_pagamentos_registros');
        $this->addSql('DROP VIEW IF EXISTS orcamento.saldo_dotacao;');
    }

    /**
     * View tesouraria.vw_orcamentaria_pagamento_estorno
     */
    private function createViewOrcamentariaPagamentoEstorno()
    {
        $this->addSql('
            CREATE OR REPLACE VIEW tesouraria.vw_orcamentaria_pagamento_estorno AS
                SELECT EOP.exercicio,
                       EOP.exercicio AS empenho_pagamento,
                       CGM.exercicio_liquidacao,
                       CGM.exercicio_empenho,
                       EOP.cod_entidade,
                       EOP.cod_empenho,
                       EOP.cod_nota,
                       empenho.retorna_empenhos(EOP.exercicio, EOP.cod_ordem, EOP.cod_entidade) AS empenho,
                       empenho.retorna_notas (EOP.exercicio, EOP.cod_ordem, EOP.cod_entidade) AS nota,
                       EOP.cod_ordem ||\'/\'|| EOP.exercicio AS ordem,
                       CGM.nom_cgm AS beneficiario,
                       0.00 AS vl_nota,
                       coalesce(EOP.vl_pago,0.00) AS vl_ordem,
                       coalesce(CGM.vl_prestado,0.00) AS vl_prestado,
                       EOP.cod_conta AS cod_conta,
                       EOP.nom_conta,
                       CASE
                           WHEN ordem_pagamento_retencao.cod_ordem IS NOT NULL THEN TRUE
                           ELSE FALSE
                       END AS retencao
                FROM
                  (SELECT EPLNLP.cod_ordem,
                          ENLP.cod_entidade,
                          ENLP.cod_empenho,
                          EPLNLP.exercicio,
                          EPLNLP.cod_nota,
                          sum(coalesce(ENLP.vl_pago,0.00)) AS vl_pago,
                          ENLP.cod_conta AS cod_conta,
                          ENLP.nom_conta AS nom_conta
                   FROM empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPLNLP
                   INNER JOIN
                     (SELECT TP.exercicio,
                             TP.cod_entidade,
                             TP.cod_nota,
                             TP.timestamp,
                             (coalesce(ENLP.vl_pago,0.00) - coalesce(TPE.vl_anulado,0.00)) AS vl_pago,
                             CPC.cod_conta AS cod_conta,
                             CPC.nom_conta AS nom_conta,
                             ENL.cod_empenho
                      FROM tesouraria.pagamento AS TP
                      LEFT JOIN
                        (SELECT ENLPA.cod_nota,
                                ENLPA.cod_entidade,
                                ENLPA.exercicio,
                                ENLPA.timestamp,
                                sum(coalesce(ENLPA.vl_anulado,0.00)) AS vl_anulado
                         FROM tesouraria.pagamento_estornado AS TPE
                         INNER JOIN empenho.nota_liquidacao_paga_anulada AS ENLPA ON ENLPA.cod_entidade = TPE.cod_entidade
                         AND ENLPA.exercicio = TPE.exercicio
                         AND ENLPA.timestamp = TPE.timestamp
                         AND ENLPA.timestamp_anulada = TPE.timestamp_anulado
                         GROUP BY ENLPA.cod_nota,
                                  ENLPA.cod_entidade,
                                  ENLPA.exercicio,
                                  ENLPA.timestamp) AS TPE ON TP.cod_nota = TPE.cod_nota
                      AND TP.cod_entidade = TPE.cod_entidade
                      AND TP.exercicio = TPE.exercicio
                      AND TP.timestamp = TPE.timestamp
                      LEFT JOIN contabilidade.plano_analitica AS CPA ON TP.cod_plano=CPA.cod_plano
                      AND TP.exercicio = CPA.exercicio
                      LEFT JOIN contabilidade.plano_conta AS CPC ON CPC.exercicio=CPA.exercicio
                      AND CPC.cod_conta = CPA.cod_conta,
                          empenho.nota_liquidacao_paga AS ENLP,
                          empenho.nota_liquidacao AS ENL
                      WHERE TP.exercicio = ENLP.exercicio
                        AND TP.cod_entidade = ENLP.cod_entidade
                        AND TP.cod_nota = ENLP.cod_nota
                        AND TP.timestamp = ENLP.timestamp
                        AND ENLP.exercicio = ENL.exercicio
                        AND ENLP.cod_entidade = ENL.cod_entidade
                        AND ENLP.cod_nota = ENL.cod_nota ) AS ENLP ON ENLP.exercicio = EPLNLP.exercicio_liquidacao
                   AND ENLP.cod_entidade = EPLNLP.cod_entidade
                   AND ENLP.cod_nota = EPLNLP.cod_nota
                   AND ENLP.timestamp = EPLNLP.timestamp
                   WHERE coalesce(ENLP.vl_pago,0.00) > 0.00
                   GROUP BY EPLNLP.cod_ordem,
                            ENLP.cod_entidade,
                            EPLNLP.cod_nota,
                            ENLP.cod_empenho,
                            EPLNLP.exercicio,
                            ENLP.cod_conta,
                            ENLP.nom_conta) AS EOP
                LEFT JOIN
                  (SELECT ordem_pagamento_retencao.exercicio,
                          ordem_pagamento_retencao.cod_entidade,
                          ordem_pagamento_retencao.cod_ordem
                   FROM empenho.ordem_pagamento_retencao
                   GROUP BY ordem_pagamento_retencao.exercicio,
                            ordem_pagamento_retencao.cod_entidade,
                            ordem_pagamento_retencao.cod_ordem) AS ordem_pagamento_retencao ON EOP.exercicio = ordem_pagamento_retencao.exercicio
                AND EOP.cod_entidade = ordem_pagamento_retencao.cod_entidade
                AND EOP.cod_ordem = ordem_pagamento_retencao.cod_ordem
                INNER JOIN
                  (SELECT EPLNLP.exercicio,
                          EPLNLP.exercicio_liquidacao,
                          EE.exercicio AS exercicio_empenho,
                          EPLNLP.cod_entidade,
                          EPLNLP.cod_ordem,
                          CGM.nom_cgm,
                          coalesce(itens.vl_prestado,0.00) AS vl_prestado
                   FROM empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPLNLP,
                        empenho.pagamento_liquidacao AS EPL,
                        empenho.nota_liquidacao AS ENL,
                        empenho.empenho AS EE
                   LEFT JOIN
                     (SELECT cod_empenho,
                             exercicio,
                             cod_entidade,
                             coalesce(SUM(valor_item),0.00) AS vl_prestado
                      FROM empenho.item_prestacao_contas AS eipc
                      WHERE NOT EXISTS
                          (SELECT num_item
                           FROM empenho.item_prestacao_contas_anulado
                           WHERE cod_empenho = eipc.cod_empenho
                             AND exercicio = eipc.exercicio
                             AND cod_entidade = eipc.cod_entidade
                             AND num_item = eipc.num_item )
                      GROUP BY cod_empenho,
                               exercicio,
                               cod_entidade) AS itens ON itens.cod_empenho = EE.cod_empenho
                   AND itens.exercicio = EE.exercicio
                   AND itens.cod_entidade = EE.cod_entidade,
                       empenho.pre_empenho AS EPE,
                       sw_cgm AS CGM
                   WHERE EPLNLP.exercicio_liquidacao = EPL.exercicio_liquidacao
                     AND EPLNLP.cod_entidade = EPL.cod_entidade
                     AND EPLNLP.cod_ordem = EPL.cod_ordem
                     AND EPLNLP.exercicio = EPL.exercicio
                     AND EPLNLP.cod_nota = EPL.cod_nota
                     AND EPL.exercicio_liquidacao = ENL.exercicio
                     AND EPL.cod_entidade = ENL.cod_entidade
                     AND EPL.cod_nota = ENL.cod_nota
                     AND ENL.exercicio_empenho = EE.exercicio
                     AND ENL.cod_entidade = EE.cod_entidade
                     AND ENL.cod_empenho = EE.cod_empenho
                     AND EE.exercicio = EPE.exercicio
                     AND EE.cod_pre_empenho = EPE.cod_pre_empenho
                     AND EPE.cgm_beneficiario = CGM.numcgm
                   GROUP BY EPLNLP.exercicio,
                            EPLNLP.cod_entidade,
                            EPLNLP.cod_ordem,
                            CGM.nom_cgm,
                            itens.vl_prestado,
                            EPLNLP.exercicio_liquidacao,
                            EE.exercicio
                   ORDER BY EPLNLP.exercicio,
                            EPLNLP.cod_entidade,
                            EPLNLP.cod_ordem,
                            CGM.nom_cgm) AS CGM ON CGM.exercicio = EOP.exercicio
                AND CGM.cod_entidade = EOP.cod_entidade
                AND CGM.cod_ordem = EOP.cod_ordem;
        ');
    }

    /**
     * View tesouraria.vw_orcamentaria_pagamentos_estorno_registros
     */
    private function createViewOrcamentariaPagamentosEstornoRegistros()
    {
        $this->addSql('
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
                    tbl."timestamp",
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
                            to_char(eem.dt_empenho, \'dd/mm/yyyy\'::text) AS dt_empenho,
                            enl.cod_nota,
                            enl.exercicio AS ex_nota,
                            to_char(enl.dt_liquidacao::timestamp with time zone, \'dd/mm/yyyy\'::text) AS dt_nota,
                            enl.cod_entidade,
                            COALESCE(sum(pag.vl_pago), 0.00) AS vl_pago,
                                CASE
                                    WHEN COALESCE(itens.vl_prestado, 0.00) <> 0.00 THEN COALESCE(sum(pag.vl_pago), 0.00) - COALESCE(itens.vl_prestado, 0.00)
                                    ELSE COALESCE(sum(pag.vl_pago), 0.00)
                                END AS vl_pagonaoprestado,
                            COALESCE(itens.vl_prestado, 0.00) AS vl_prestado,
                            pag."timestamp",
                            to_char(pag."timestamp", \'dd/mm/yyyy\'::text) AS dt_pagamento,
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
                                    plnlp."timestamp",
                                    plnlp.exercicio_liquidacao,
                                    COALESCE(sum(tnlp.vl_pago), 0.00) AS vl_pago,
                                    tnlp.exercicio_plano,
                                    tnlp.cod_plano
                                   FROM empenho.pagamento_liquidacao_nota_liquidacao_paga plnlp
                                     LEFT JOIN ( SELECT nlp.exercicio,
                                            nlp.cod_entidade,
                                            nlp.cod_nota,
                                            nlp."timestamp",
                                            COALESCE(nlp.vl_pago, 0.00) - COALESCE(nlpa.vl_pago_anulado, 0.00) AS vl_pago,
                                            nlcp.exercicio AS exercicio_plano,
                                            nlcp.cod_plano
                                           FROM empenho.nota_liquidacao_paga nlp
                                             LEFT JOIN ( SELECT nlpa_1.exercicio,
                                                    nlpa_1.cod_nota,
                                                    nlpa_1.cod_entidade,
                                                    nlpa_1."timestamp",
                                                    COALESCE(sum(nlpa_1.vl_anulado), 0.00) AS vl_pago_anulado
                                                   FROM empenho.nota_liquidacao_paga_anulada nlpa_1
                                                  GROUP BY nlpa_1.exercicio, nlpa_1.cod_nota, nlpa_1.cod_entidade, nlpa_1."timestamp") nlpa ON nlpa.exercicio = nlp.exercicio AND nlpa.cod_nota = nlp.cod_nota AND nlpa.cod_entidade = nlp.cod_entidade AND nlpa."timestamp" = nlp."timestamp"
                                             LEFT JOIN empenho.nota_liquidacao_conta_pagadora nlcp ON nlcp.exercicio_liquidacao = nlp.exercicio AND nlcp.cod_entidade = nlp.cod_entidade AND nlcp.cod_nota = nlp.cod_nota AND nlcp."timestamp" = nlp."timestamp") tnlp ON tnlp.exercicio = plnlp.exercicio_liquidacao AND tnlp.cod_nota = plnlp.cod_nota AND tnlp.cod_entidade = plnlp.cod_entidade AND tnlp."timestamp" = plnlp."timestamp"
                                  GROUP BY plnlp.exercicio, plnlp.cod_entidade, plnlp.cod_ordem, plnlp.cod_nota, plnlp."timestamp", plnlp.exercicio_liquidacao, tnlp.exercicio_plano, tnlp.cod_plano) pag ON pag.exercicio = epl.exercicio AND pag.cod_entidade = epl.cod_entidade AND pag.cod_ordem = epl.cod_ordem AND pag.cod_nota = epl.cod_nota AND pag.exercicio_liquidacao = epl.exercicio_liquidacao
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
                          GROUP BY eem.cod_empenho, eem.exercicio, (to_char(eem.dt_empenho, \'dd/mm/yyyy\'::text)), enl.cod_nota, enl.exercicio, (to_char(enl.dt_liquidacao::timestamp with time zone, \'dd/mm/yyyy\'::text)), enl.cod_entidade, epl.vl_pagamento, itens.vl_prestado, opla.vl_anulado, pag."timestamp", ode.cod_recurso, rpe.recurso, pag.exercicio_plano, pag.cod_plano, epl.cod_ordem, epl.exercicio
                          ORDER BY enl.cod_nota) tbl
                          WHERE tbl.vl_pago > 0::numeric;
        ');
    }

    /**
     * View tesouraria.vw_orcamentaria_pagamentos
     */
    private function createViewOrcamentariaPagamentos()
    {
        $this->addSql('
            CREATE OR REPLACE VIEW tesouraria.vw_orcamentaria_pagamentos AS
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
                        \'\'::text AS dt_estorno,
                        COALESCE(sum(tabela.valor_pagamento), 0.00) AS valor_pagamento,
                        COALESCE(sum(tabela.valor_anulada), 0.00) AS valor_anulada,
                        COALESCE(sum(tabela.saldo_pagamento), 0.00) AS saldo_pagamento,
                        tabela.nota_empenho,
                        tabela.vl_nota,
                        tabela.vl_nota_anulacoes,
                        tabela.vl_nota_original,
                            CASE
                                WHEN sum(COALESCE(tabela.saldo_pagamento, 0.00)) < COALESCE(tabela.vl_nota, 0.00) AND tabela.vl_nota > 0.00 THEN \'A Pagar\'::text
                                WHEN sum(COALESCE(tabela.saldo_pagamento, 0.00)) = COALESCE(tabela.vl_nota, 0.00) AND tabela.vl_nota > 0.00 THEN \'Paga\'::text
                                WHEN tabela.vl_nota = 0.00 THEN \'Anulada\'::text
                                ELSE NULL::text
                            END AS situacao,
                            CASE
                                WHEN COALESCE(sum(tabela.valor_anulada), 0.00) > 0.00 THEN \'Sim\'::text
                                ELSE \'Não\'::text
                            END AS pagamento_estornado
                       FROM ( SELECT op.cod_ordem,
                                op.exercicio,
                                op.cod_entidade,
                                to_char(op.dt_emissao::timestamp with time zone, \'dd/mm/yyyy\'::text) AS dt_emissao,
                                to_char(op.dt_vencimento::timestamp with time zone, \'dd/mm/yyyy\'::text) AS dt_vencimento,
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
                                empenho.retorna_notas_empenhos(op.exercicio, op.cod_ordem, op.cod_entidade) AS nota_empenho,
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
                                                nlpa_1."timestamp",
                                                COALESCE(sum(nlpa_1.vl_anulado), 0.00) AS vl_anulado
                                               FROM empenho.nota_liquidacao_paga_anulada nlpa_1
                                              GROUP BY nlpa_1.exercicio, nlpa_1.cod_nota, nlpa_1.cod_entidade, nlpa_1."timestamp") nlpa ON nlp.exercicio::text = nlpa.exercicio::text AND nlp.cod_nota = nlpa.cod_nota AND nlp.cod_entidade = nlpa.cod_entidade AND nlp."timestamp" = nlpa."timestamp"
                                      WHERE nlp.cod_entidade = plnlp.cod_entidade AND nlp.cod_nota = plnlp.cod_nota AND nlp.exercicio::text = plnlp.exercicio_liquidacao::text AND nlp."timestamp" = plnlp."timestamp"
                                      GROUP BY nlp.cod_entidade, nlp.cod_nota, nlp.exercicio, nlpa.vl_anulado, plnlp.cod_ordem, plnlp.exercicio) nota_liq_paga ON pl.cod_nota = nota_liq_paga.cod_nota AND pl.cod_entidade = nota_liq_paga.cod_entidade AND pl.exercicio::text = nota_liq_paga.exercicio::text AND pl.cod_ordem = nota_liq_paga.cod_ordem AND pl.exercicio_liquidacao::text = nota_liq_paga.exercicio_liquidacao::text
                                 JOIN empenho.empenho em ON nl.cod_empenho = em.cod_empenho AND nl.exercicio_empenho::text = em.exercicio::text AND nl.cod_entidade = em.cod_entidade
                                 JOIN empenho.pre_empenho pe ON em.exercicio::text = pe.exercicio::text AND em.cod_pre_empenho = pe.cod_pre_empenho
                                 JOIN sw_cgm cgm_pe ON pe.cgm_beneficiario = cgm_pe.numcgm
                                 LEFT JOIN empenho.pre_empenho_despesa ped ON pe.cod_pre_empenho = ped.cod_pre_empenho AND pe.exercicio::text = ped.exercicio::text
                                 LEFT JOIN orcamento.despesa de ON ped.cod_despesa = de.cod_despesa AND ped.exercicio::text = de.exercicio::text
                                 LEFT JOIN orcamento.recurso(\'\'::character varying) rec(cod_recurso, exercicio, nom_recurso, tipo, nom_tipo, cod_fonte, masc_recurso, masc_recurso_red, cod_uso, cod_destinacao, cod_especificacao, cod_detalhamento, finalidade) ON de.cod_recurso = rec.cod_recurso AND de.exercicio::bpchar = rec.exercicio
                                 JOIN orcamento.entidade en ON op.cod_entidade = en.cod_entidade AND op.exercicio::text = en.exercicio::text
                                 JOIN sw_cgm cgm ON en.numcgm = cgm.numcgm
                              GROUP BY op.cod_ordem, op.exercicio, op.cod_entidade, to_char(op.dt_emissao::timestamp with time zone, \'dd/mm/yyyy\'::text), to_char(op.dt_vencimento::timestamp with time zone, \'dd/mm/yyyy\'::text), op.observacao, cgm.nom_cgm, 1::integer, em.exercicio, de.cod_recurso, rec.masc_recurso_red, rec.cod_recurso, rec.cod_detalhamento, pe.cgm_beneficiario, pe.implantado, cgm_pe.nom_cgm, empenho.retorna_notas_empenhos(op.exercicio, op.cod_ordem, op.cod_entidade), pl.exercicio_liquidacao, nota_liq_paga.cod_nota, nota_liq_paga.vl_pago, nota_liq_paga.vl_anulado, nota_liq_paga.saldo_pagamento) tabela
                      GROUP BY tabela.cod_ordem, tabela.exercicio, tabela.cod_entidade, tabela.dt_emissao, tabela.dt_vencimento, tabela.observacao, tabela.entidade, tabela.cod_recurso, tabela.masc_recurso_red, tabela.cod_detalhamento, tabela.cgm_beneficiario, tabela.implantado, tabela.beneficiario, \'\'::text, tabela.nota_empenho, tabela.exercicio_empenho, tabela.vl_nota, tabela.vl_nota_original, tabela.vl_nota_anulacoes) tbl
              WHERE tbl.num_exercicio_empenho > 0;
        ');
    }

    /**
     * View tesouraria.vw_orcamentaria_pagamentos_registros
     */
    private function createViewOrcamentariaPagamentosRegistros()
    {
        $this->addSql('
        CREATE OR REPLACE VIEW tesouraria.vw_orcamentaria_pagamentos_registros AS
        SELECT
        *
        FROM (
            SELECT
                    eem.cod_empenho,
                    eem.exercicio AS ex_empenho,
                    to_char (
                        eem.dt_empenho,
                        \'dd/mm/yyyy\' ) AS dt_empenho,
                    enl.cod_nota,
                    enl.exercicio AS ex_nota,
                    to_char (
                        enl.dt_liquidacao,
                        \'dd/mm/yyyy\' ) AS dt_nota,
                    enl.cod_entidade,
                    COALESCE (
                        sum (
                            pag.vl_pago ),
                        0.00 ) AS vl_pago,
                    CASE
                        WHEN COALESCE (
                itens.vl_prestado,
                0.00 )
            != 0.00 THEN COALESCE (
                sum (
                    pag.vl_pago ),
                0.00 )
            - COALESCE (
                itens.vl_prestado,
                0.00 )
                        ELSE COALESCE (
                sum (
                    pag.vl_pago ),
                0.00 )
                    END AS vl_pagonaoprestado,
                    COALESCE (
                        itens.vl_prestado,
                        0.00 ) AS vl_prestado,
                    pag.timestamp,
                    to_char (
                        pag.timestamp,
                        \'dd/mm/yyyy\' ) AS dt_pagamento,
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
                FROM
                    empenho.pagamento_liquidacao AS epl
                LEFT JOIN (
                SELECT
                        opla.cod_nota,
                        opla.exercicio_liquidacao,
                        opla.cod_entidade,
                        opla.cod_ordem,
                        opla.exercicio,
                        sum (
                            opla.vl_anulado ) AS vl_anulado
                    FROM
                        empenho.ordem_pagamento_liquidacao_anulada AS opla
                    GROUP BY
                        opla.cod_nota,
                        opla.exercicio_liquidacao,
                        opla.cod_entidade,
                        opla.cod_ordem,
                        opla.exercicio ) AS opla ON (
                opla.cod_nota = epl.cod_nota
                AND opla.exercicio_liquidacao = epl.exercicio_liquidacao
                AND opla.cod_entidade = epl.cod_entidade
                AND opla.cod_ordem = epl.cod_ordem
                AND opla.exercicio = epl.exercicio )
                LEFT JOIN (
                SELECT
                        plnlp.exercicio,
                        plnlp.cod_entidade,
                        plnlp.cod_ordem,
                        plnlp.cod_nota,
                        plnlp.timestamp,
                        plnlp.exercicio_liquidacao,
                        COALESCE (
                            sum (
                                tnlp.vl_pago ),
                            0.00 ) AS vl_pago,
                        tnlp.exercicio_plano,
                        tnlp.cod_plano
                    FROM
                        empenho.pagamento_liquidacao_nota_liquidacao_paga AS plnlp
                    LEFT JOIN (
                SELECT
                            nlp.exercicio,
                            nlp.cod_entidade,
                            nlp.cod_nota,
                            nlp.timestamp,
                            COALESCE (
                                vl_pago,
                                0.00 )
                            - COALESCE (
                                vl_pago_anulado,
                                0.00 ) AS vl_pago,
                            nlcp.exercicio AS exercicio_plano,
                            nlcp.cod_plano
                        FROM
                            empenho.nota_liquidacao_paga AS nlp
                        LEFT JOIN (
                SELECT
                                nlpa.exercicio,
                                nlpa.cod_nota,
                                nlpa.cod_entidade,
                                nlpa.timestamp,
                                COALESCE (
                                    sum (
                                        vl_anulado ),
                                    0.00 ) AS vl_pago_anulado
                            FROM
                                empenho.nota_liquidacao_paga_anulada AS nlpa
                            GROUP BY
                                nlpa.exercicio,
                                nlpa.cod_nota,
                                nlpa.cod_entidade,
                                nlpa.timestamp ) AS nlpa ON (
                nlpa.exercicio = nlp.exercicio
                AND nlpa.cod_nota = nlp.cod_nota
                AND nlpa.cod_entidade = nlp.cod_entidade
                AND nlpa.timestamp = nlp.timestamp )
                        LEFT JOIN empenho.nota_liquidacao_conta_pagadora AS nlcp ON (
                nlcp.exercicio_liquidacao = nlp.exercicio
                AND nlcp.cod_entidade = nlp.cod_entidade
                AND nlcp.cod_nota = nlp.cod_nota
                AND nlcp.timestamp = nlp.timestamp ) ) AS tnlp ON (
                tnlp.exercicio = plnlp.exercicio_liquidacao
                AND tnlp.cod_nota = plnlp.cod_nota
                AND tnlp.cod_entidade = plnlp.cod_entidade
                AND tnlp.timestamp = plnlp.timestamp )
                GROUP BY
                    plnlp.exercicio,
                    plnlp.cod_entidade,
                    plnlp.cod_ordem,
                    plnlp.cod_nota,
                    plnlp.timestamp,
                    plnlp.exercicio_liquidacao,
                    tnlp.exercicio_plano,
                    tnlp.cod_plano ) AS pag ON (
                pag.exercicio = epl.exercicio
                AND pag.cod_entidade = epl.cod_entidade
                AND pag.cod_ordem = epl.cod_ordem
                AND pag.cod_nota = epl.cod_nota
                AND pag.exercicio_liquidacao = epl.exercicio_liquidacao )
                JOIN empenho.nota_liquidacao AS enl ON (
                epl.exercicio_liquidacao = enl.exercicio
                AND epl.cod_nota = enl.cod_nota
                AND epl.cod_entidade = enl.cod_entidade )
                JOIN empenho.empenho AS eem ON (
                enl.exercicio_empenho = eem.exercicio
                AND enl.cod_entidade = eem.cod_entidade
                AND enl.cod_empenho = eem.cod_empenho )
                LEFT JOIN (
                SELECT
                        cod_empenho,
                        exercicio,
                        cod_entidade,
                        COALESCE (
                            sum (
                                valor_item ),
                            0.00 ) AS vl_prestado
                    FROM
                        empenho.item_prestacao_contas AS eipc
                    WHERE
                        NOT EXISTS (
                SELECT
                                num_item
                            FROM
                                empenho.item_prestacao_contas_anulado
                            WHERE
                                cod_empenho = eipc.cod_empenho
                                AND exercicio = eipc.exercicio
                                AND cod_entidade = eipc.cod_entidade
                                AND num_item = eipc.num_item )
                    GROUP BY
                        cod_empenho,
                        exercicio,
                        cod_entidade ) AS itens ON (
                itens.cod_empenho = eem.cod_empenho
                AND itens.exercicio = eem.exercicio
                AND itens.cod_entidade = eem.cod_entidade )
                JOIN empenho.pre_empenho AS epe ON (
                eem.exercicio = epe.exercicio
                AND eem.cod_pre_empenho = epe.cod_pre_empenho )
                LEFT JOIN empenho.pre_empenho_despesa AS epd ON (
                epe.exercicio = epd.exercicio
                AND epe.cod_pre_empenho = epd.cod_pre_empenho )
                LEFT JOIN orcamento.despesa AS ode ON (
                epd.exercicio = ode.exercicio
                AND epd.cod_despesa = ode.cod_despesa )
                LEFT JOIN empenho.restos_pre_empenho AS rpe ON (
                epe.exercicio = rpe.exercicio
                AND epe.cod_pre_empenho = rpe.cod_pre_empenho )
            GROUP BY
                eem.cod_empenho,
                eem.exercicio,
                to_char (
                    eem.dt_empenho,
                    \'dd/mm/yyyy\' ),
                enl.cod_nota,
                enl.exercicio,
                to_char (
                    enl.dt_liquidacao,
                    \'dd/mm/yyyy\' ),
                enl.cod_entidade,
                epl.vl_pagamento,
                itens.vl_prestado,
                opla.vl_anulado,
                pag.timestamp,
                ode.cod_recurso,
                rpe.recurso,
                pag.exercicio_plano,
                pag.cod_plano,
                epl.cod_ordem,
                epl.exercicio
            ORDER BY
                enl.cod_nota ) AS tbl
        WHERE
            vl_pago = 0;       
        ');
    }

    /**
     * View orcamento.saldo_dotacao
     */
    private function createViewSaldoDotacao()
    {
        $this->addSql('
            CREATE OR REPLACE VIEW orcamento.saldo_dotacao AS
            SELECT *,
             (valor_orcado + valor_suplementado - valor_reduzido - valor_empenhado + valor_anulado - valor_reserva) as saldo_disponivel  ,(valor_orcado - valor_reserva) as saldo, row_number() OVER () as rnum FROM(
             SELECT
                  D.cod_entidade,
                  D.exercicio,
                  CGM.nom_cgm as entidade,
                  D.cod_despesa,
                  CD.cod_conta,
                  CD.descricao,
                  D.num_orgao,
                  OO.nom_orgao,       D.num_unidade,
                  OU.nom_unidade,       D.cod_funcao,
                  F.descricao as funcao,
                  D.cod_subfuncao,
                  SF.descricao as subfuncao,
                  D.cod_programa,
                  ppa.programa.num_programa AS num_programa,
                  P.descricao as programa,
                  D.num_pao,
                  ppa.acao.num_acao AS num_acao,
                  PAO.nom_pao,
                  CD.cod_estrutural,
                  D.cod_recurso,
                  R.nom_recurso,
                  R.cod_fonte,
                  R.masc_recurso_red,
                  R.cod_detalhamento,
                  coalesce(sum(D.vl_original),0.00) as valor_orcado,
                  coalesce(sum(SS.valor),0.00)      as valor_suplementado,
                  coalesce(sum(SR.valor),0.00)      as valor_reduzido,
                  coalesce(sum(RS.vl_reserva),0.00) as valor_reserva,
                  coalesce(sum(EMP.vl_empenhado),0.00) as valor_empenhado,
                  coalesce(sum(EMP.vl_anulado),0.00)   as valor_anulado,
                  coalesce(sum(EMP.vl_liquidado),0.00) as valor_liquidado,
                  coalesce(sum(EMP.vl_pago),0.00)      as valor_pago
              FROM
                  orcamento.despesa        AS D
                    LEFT JOIN (
                        SELECT
                            SSUP.cod_despesa,
                            SSUP.exercicio,
                            coalesce(sum(SSUP.valor),0.00) as valor
                        FROM
                            orcamento.suplementacao_suplementada    as SSUP,
                            orcamento.suplementacao                 as S
                        WHERE
                            SSUP.cod_suplementacao  = S.cod_suplementacao   AND
                            SSUP.exercicio          = S.exercicio
            
                        AND S.cod_tipo <> 16
                        AND ( select sa.cod_suplementacao
                                from orcamento.suplementacao_anulada as sa
                               where sa.exercicio = S.exercicio
                                 and sa.cod_suplementacao = S.cod_suplementacao
                            ) IS NULL
            
                   GROUP BY SSUP.cod_despesa, SSUP.exercicio
                    )  as SS ON
                        D.cod_despesa   = SS.cod_despesa    AND
                        D.exercicio     = SS.exercicio
                    LEFT JOIN (
                        SELECT
                            SRED.cod_despesa,
                            SRED.exercicio,
                            coalesce(sum(SRED.valor),0.00) as valor
                        FROM
                            orcamento.suplementacao_reducao         as SRED,
                            orcamento.suplementacao                 as S
                        WHERE
                            SRED.cod_suplementacao  = S.cod_suplementacao   AND
                            SRED.exercicio          = S.exercicio
            
                        AND S.cod_tipo <> 16
                        AND ( select sa.cod_suplementacao
                                from orcamento.suplementacao_anulada as sa
                               where sa.exercicio = S.exercicio
                                 and sa.cod_suplementacao = S.cod_suplementacao
                            ) IS NULL
            
                   GROUP BY SRED.cod_despesa, SRED.exercicio
                    ) as SR ON
                        D.cod_despesa   = SR.cod_despesa    AND
                        D.exercicio     = SR.exercicio
                    LEFT JOIN (
                        SELECT
                            R.cod_despesa,
                            R.exercicio,
                            coalesce(sum(R.vl_reserva),0.00) as vl_reserva
                        FROM
                            orcamento.reserva_saldos        AS R
                        WHERE NOT EXISTS ( SELECT 1
                                             FROM orcamento.reserva_saldos_anulada orsa
                                            WHERE orsa.cod_reserva = R.cod_reserva
                                              AND orsa.exercicio   = R.exercicio
                                         )
                                              AND R.dt_validade_final > to_date(now()::varchar, \'yyyy-mm-dd\')
                    GROUP BY R.cod_despesa, R.exercicio
                    )            as RS ON
                        D.cod_despesa   = RS.cod_despesa    AND
                        D.exercicio     = RS.exercicio
                    LEFT JOIN (
                        SELECT
                            PD.cod_despesa,
                            PD.exercicio,
                            EE.cod_entidade,
                            coalesce(sum(EMP.valor),0.00)               as vl_empenhado,
                            coalesce(sum(ANU.valor),0.00)               as vl_anulado,
                            (coalesce(sum(NL.vl_liquidado),0.00) - coalesce(sum(NL.vl_liquidado_anulado),0.00)) as vl_liquidado,
                            (coalesce(sum(NL.vl_pago),0.00) - coalesce(sum(NL.vl_estornado),0.00))              as vl_pago
                        FROM
                                empenho.empenho             AS EE
                                    LEFT JOIN (
                                        SELECT
                                            PE.exercicio,
                                            PE.cod_pre_empenho,
                                            coalesce(sum(IE.vl_total),0.00) as valor
                                        FROM
                                            empenho.empenho                       AS E,
                                            empenho.pre_empenho                   AS PE,
                                            empenho.item_pre_empenho              AS IE
                                        WHERE
                                                E.cod_pre_empenho   = PE.cod_pre_empenho
                                        AND     E.exercicio         = PE.exercicio
                                        AND     IE.cod_pre_empenho   = PE.cod_pre_empenho
                                        AND     IE.exercicio         = PE.exercicio
                                        GROUP BY PE.exercicio,PE.cod_pre_empenho
                                    ) as EMP ON (
                                                EMP.exercicio         = EE.exercicio
                                        AND     EMP.cod_pre_empenho   = EE.cod_pre_empenho
                                    )
                                    LEFT JOIN (
                                        SELECT
                                            EA.exercicio,
                                            EA.cod_empenho,
                                            EA.cod_entidade,
                                            coalesce(sum(EAI.vl_anulado),0.00) as valor
                                        FROM
                                            empenho.empenho_anulado               AS EA,
                                            empenho.empenho_anulado_item          AS EAI
                                       WHERE
                                                EA.exercicio        = EAI.exercicio
                                        AND     EA.cod_entidade     = EAI.cod_entidade
                                        AND     EA.cod_empenho      = EAI.cod_empenho
                                        AND     EA.timestamp        = EAI.timestamp
                                    GROUP BY EA.exercicio, EA.cod_empenho, EA.cod_entidade
                                    ) as ANU ON (
                                                ANU.exercicio     = EE.exercicio
                                        AND     ANU.cod_empenho   = EE.cod_empenho
                                        AND     ANU.cod_entidade  = EE.cod_entidade
                                    )
                                    LEFT JOIN (
                                        SELECT
                                            NL.exercicio,
                                            NL.cod_empenho,
                                            NL.cod_entidade,
                                            sum(NLI.vl_total)       as vl_liquidado,
                                            sum(NLIA.valor)         as vl_liquidado_anulado,
                                            sum(NLP.vl_pago)        as vl_pago,
                                            sum(NLPA.vl_estornado)  as vl_estornado
                                        FROM
                                            empenho.nota_liquidacao             AS NL
                                            LEFT JOIN (
                                            select
                                                exercicio,
                                                cod_nota,
                                                cod_entidade,
                                                coalesce(sum(vl_total),0.00)as vl_total
                                                from
                                                empenho.nota_liquidacao_item
                                                group by
                                                exercicio,cod_nota,cod_entidade
                                            ) as NLI on
                                                NL.exercicio         = NLI.exercicio
                                            AND NL.cod_nota          = NLI.cod_nota
                                            AND NL.cod_entidade      = NLI.cod_entidade
                                                LEFT JOIN (
                                                    SELECT
                                                        NLI.exercicio,
                                                        NLI.cod_nota,
                                                        NLI.cod_entidade,
                                                        coalesce(sum(NLIA.vl_anulado),0.00) as valor
                                                    FROM
                                                        empenho.nota_liquidacao_item            AS NLI,
                                                        empenho.nota_liquidacao_item_anulado    AS NLIA
                                                    WHERE
                                                            NLI.exercicio        = NLIA.exercicio
                                                        AND NLI.cod_nota         = NLIA.cod_nota
                                                        AND NLI.num_item         = NLIA.num_item
                                                        AND NLI.exercicio_item   = NLIA.exercicio_item
                                                        AND NLI.cod_pre_empenho  = NLIA.cod_pre_empenho
                                                        AND NLI.cod_entidade     = NLIA.cod_entidade
                                                 GROUP BY nli.exercicio, nli.cod_nota, nli.cod_entidade
                                                ) as NLIA ON
                                                        NL.exercicio         = NLIA.exercicio
                                                    AND NL.cod_nota          = NLIA.cod_nota
                                                    AND NL.cod_entidade      = NLIA.cod_entidade
            
                                                LEFT JOIN (
                                                   SELECT
                                                       coalesce(sum(NLP.vl_pago),0.00) as vl_pago,
                                                       NLP.exercicio,
                                                       NLP.cod_entidade,
                                                       NLP.cod_nota
                                                   FROM
                                                       empenho.nota_liquidacao_paga AS NLP
            
                                                   GROUP BY NLP.exercicio, NLP.cod_entidade, NLP.cod_nota
                                               ) as NLP ON
                                                       NL.exercicio         = NLP.exercicio
                                                   AND NL.cod_nota          = NLP.cod_nota
                                                   AND NL.cod_entidade      = NLP.cod_entidade
            
                                                LEFT JOIN (
                                                    SELECT
                                                        NLP.exercicio,
                                                        NLP.cod_nota,
                                                        NLP.cod_entidade,
                                                        coalesce(sum(NLPA.vl_anulado),0.00) as vl_estornado
                                                    FROM
                                                        empenho.nota_liquidacao_paga            AS NLP,
                                                        empenho.nota_liquidacao_paga_anulada    AS NLPA
                                                    WHERE
                                                            NLP.exercicio        = NLPA.exercicio
                                                        AND NLP.cod_nota         = NLPA.cod_nota
                                                        AND NLP.cod_entidade     = NLPA.cod_entidade
                                                        AND NLP.timestamp        = NLPA.timestamp
                                                     GROUP BY nlp.exercicio,nlp.cod_nota,nlp.cod_entidade
                                    ) as NLPA ON
                                                        NL.exercicio         = NLPA.exercicio
                                                    AND NL.cod_nota          = NLPA.cod_nota
                                                    AND NL.cod_entidade      = NLPA.cod_entidade
                                        GROUP BY
                                            NL.exercicio,
                                            NL.cod_empenho,
                                            NL.cod_entidade
                                    ) as NL ON (
                                                NL.exercicio     = EE.exercicio
                                        AND     NL.cod_empenho   = EE.cod_empenho
                                        AND     NL.cod_entidade  = EE.cod_entidade
                                    )
                                ,empenho.pre_empenho         AS PE
                                ,empenho.pre_empenho_despesa AS PD
                        WHERE
                                   EE.cod_pre_empenho = PE.cod_pre_empenho
                            AND    EE.exercicio       = PE.exercicio
            
                            AND    PD.cod_pre_empenho = PE.cod_pre_empenho
                            AND    PD.exercicio       = PE.exercicio
                        GROUP BY
                            PD.cod_despesa,
                            PD.exercicio,
                            EE.cod_entidade
            
                    ) AS EMP ON
                        D.cod_despesa   = EMP.cod_despesa   AND
                        D.exercicio     = EMP.exercicio     AND
                        D.cod_entidade  = EMP.cod_entidade
                        JOIN orcamento.programa_ppa_programa
                          ON programa_ppa_programa.cod_programa = D.cod_programa
                         AND programa_ppa_programa.exercicio   = D.exercicio
                        JOIN ppa.programa
                          ON ppa.programa.cod_programa = programa_ppa_programa.cod_programa_ppa
                        JOIN orcamento.pao_ppa_acao
                          ON pao_ppa_acao.num_pao = D.num_pao
                         AND pao_ppa_acao.exercicio = D.exercicio
                        JOIN ppa.acao
                          ON ppa.acao.cod_acao = pao_ppa_acao.cod_acao
                  ,orcamento.conta_despesa  AS CD
                  ,orcamento.entidade       AS E
                  ,sw_cgm                   AS CGM
                  ,orcamento.orgao          AS OO
                  ,orcamento.unidade        AS OU
                  ,orcamento.funcao         AS F
                  ,orcamento.subfuncao      AS SF
                  ,orcamento.programa       AS P
                  ,orcamento.pao            AS PAO
                  --,orcamento.recurso(EXTRACT ( YEAR FROM to_date(\'31/12/2016\'::varchar, \'dd/mm/yyyy\'))::varchar) AS R
                  ,orcamento.recurso(D.exercicio) as R
              WHERE
                      D.cod_conta     = CD.cod_conta
                  AND D.exercicio     = CD.exercicio
                  AND D.exercicio     = OU.exercicio
                  AND D.num_unidade   = OU.num_unidade
                  AND D.num_orgao     = OU.num_orgao
                  AND D.exercicio     = E.exercicio
                  AND D.cod_entidade  = E.cod_entidade
                  AND E.numcgm        = CGM.numcgm
                  AND OU.exercicio    = OO.exercicio
                  AND OU.num_orgao    = OO.num_orgao
                  AND D.exercicio     = F.exercicio
                  AND D.cod_funcao    = F.cod_funcao
                  AND D.exercicio     = SF.exercicio
                  AND D.cod_subfuncao = SF.cod_subfuncao
                  AND D.exercicio     = P.exercicio
                  AND D.cod_programa  = P.cod_programa
                  AND D.exercicio     = PAO.exercicio
                  AND D.num_pao       = PAO.num_pao
                  AND D.exercicio     = R.exercicio
                  AND D.cod_recurso   = R.cod_recurso
             --AND D.exercicio = \'2016\'
                    GROUP BY
                          D.cod_entidade,
                          D.exercicio,
                          CGM.nom_cgm,
            
                          D.cod_despesa,
                          CD.cod_conta,
                          CD.descricao,
            
                          D.num_orgao,
                          OO.nom_orgao,
                          OU.nom_unidade,
            
                          D.num_unidade,
            
                          D.cod_funcao,
                          F.descricao,
            
                          D.cod_subfuncao,
                          SF.descricao,
            
                          D.cod_programa,
                          ppa.programa.num_programa,
                          P.descricao,
            
                          D.num_pao,
                          ppa.acao.num_acao,
                          PAO.nom_pao,
            
                          CD.cod_estrutural,
            
                          D.cod_recurso,
                          R.nom_recurso,
                          R.masc_recurso,
                          R.cod_fonte,
                          R.masc_recurso_red,
                          R.cod_detalhamento
            
                 ORDER BY D.cod_entidade, D.cod_despesa ) as tabela;');
    }
}
