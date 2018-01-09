<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170130090700 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
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
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP VIEW tesouraria.vw_orcamentaria_pagamentos;');
    }
}
