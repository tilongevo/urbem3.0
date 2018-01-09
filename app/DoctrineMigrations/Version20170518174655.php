<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Entity\Imobiliario\CondominioAreaComum;
use Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170518174655 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_edificacao;');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_construcao_outros;');

        $this->changeColumnToDateTimeMicrosecondType(Condominio::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CondominioProcesso::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CondominioAreaComum::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoCondominioValor::class, 'timestamp');

        $this->addSql('
             CREATE OR REPLACE VIEW imobiliario.vw_edificacao AS
             SELECT ed.cod_construcao,
                cc."timestamp" AS timestamp_construcao,
                ud.cod_construcao AS cod_construcao_autonoma,
                ed.cod_tipo,
                ud.cod_tipo AS cod_tipo_autonoma,
                ac.area_real,
                te.nom_tipo,
                cp.cod_processo,
                cp.exercicio,
                to_char(bc.dt_inicio::timestamp with time zone, \'dd/mm/yyyy\'::text) AS data_baixa,
                to_char(bc.dt_termino::timestamp with time zone, \'dd/mm/yyyy\'::text) AS data_reativacao,
                bc."timestamp" AS timestamp_baixa,
                bc.justificativa,
                dc.data_construcao,
                bc.sistema,
                    CASE
                        WHEN ud.inscricao_municipal IS NOT NULL THEN ud.inscricao_municipal
                        WHEN ua.inscricao_municipal IS NOT NULL THEN ua.inscricao_municipal
                        ELSE cd.cod_condominio
                    END AS imovel_cond,
                cd.nom_condominio,
                    CASE
                        WHEN ud.inscricao_municipal::character varying IS NOT NULL THEN imobiliario.fn_area_unidade_dependente(ed.cod_construcao, ud.inscricao_municipal)::character varying
                        WHEN ua.inscricao_municipal::character varying IS NOT NULL THEN imobiliario.fn_area_unidade_autonoma(ed.cod_construcao, ua.inscricao_municipal)::character varying
                        ELSE NULL::character varying
                    END AS area_unidade,
                    CASE
                        WHEN ud.inscricao_municipal::character varying IS NOT NULL THEN \'Dependente\'::text
                        WHEN ua.inscricao_municipal::character varying IS NOT NULL THEN \'Autônoma\'::text
                        ELSE \'Condomínio\'::text
                    END AS tipo_vinculo
               FROM imobiliario.construcao_edificacao ed
                 JOIN imobiliario.construcao cc ON cc.cod_construcao = ed.cod_construcao
                 JOIN imobiliario.data_construcao dc ON dc.cod_construcao = ed.cod_construcao
                 LEFT JOIN ( SELECT ac_1.cod_construcao,
                        ac_1."timestamp",
                        ac_1.area_real
                       FROM imobiliario.area_construcao ac_1,
                        ( SELECT max(area_construcao."timestamp") AS "timestamp",
                                area_construcao.cod_construcao
                               FROM imobiliario.area_construcao
                              GROUP BY area_construcao.cod_construcao) mac
                      WHERE ac_1.cod_construcao = mac.cod_construcao AND ac_1."timestamp" = mac."timestamp") ac ON ac.cod_construcao = ed.cod_construcao
                 JOIN imobiliario.tipo_edificacao te ON te.cod_tipo = ed.cod_tipo
                 LEFT JOIN ( SELECT cp_1.cod_construcao,
                        cp_1.cod_processo,
                        cp_1.exercicio,
                        cp_1."timestamp"
                       FROM imobiliario.construcao_processo cp_1,
                        ( SELECT max(construcao_processo."timestamp") AS "timestamp",
                                construcao_processo.cod_construcao
                               FROM imobiliario.construcao_processo
                              GROUP BY construcao_processo.cod_construcao) mcp
                      WHERE cp_1.cod_construcao = mcp.cod_construcao AND cp_1."timestamp" = mcp."timestamp") cp ON ed.cod_construcao = cp.cod_construcao
                 LEFT JOIN imobiliario.unidade_dependente ud ON ud.cod_construcao_dependente = ed.cod_construcao
                 LEFT JOIN imobiliario.unidade_autonoma ua ON ua.cod_construcao = ed.cod_construcao
                 LEFT JOIN ( SELECT cc_1.cod_construcao,
                        cd_1.cod_condominio,
                        cd_1.cod_tipo,
                        cd_1.nom_condominio,
                        cd_1."timestamp"
                       FROM imobiliario.construcao_condominio cc_1,
                        imobiliario.condominio cd_1
                      WHERE cd_1.cod_condominio = cc_1.cod_condominio) cd ON cd.cod_construcao = ed.cod_construcao
                 LEFT JOIN ( SELECT bal.cod_construcao,
                        bal."timestamp",
                        bal.justificativa,
                        bal.sistema,
                        bal.justificativa_termino,
                        bal.dt_inicio,
                        bal.dt_termino
                       FROM imobiliario.baixa_construcao bal,
                        ( SELECT max(baixa_construcao."timestamp") AS "timestamp",
                                baixa_construcao.cod_construcao
                               FROM imobiliario.baixa_construcao
                              GROUP BY baixa_construcao.cod_construcao) bt
                      WHERE bal.cod_construcao = bt.cod_construcao AND bal."timestamp" = bt."timestamp") bc ON ed.cod_construcao = bc.cod_construcao
              WHERE
                    CASE
                        WHEN bc."timestamp" IS NOT NULL AND bc.dt_termino IS NULL THEN
                        CASE
                            WHEN bc.sistema = true THEN false
                            ELSE true
                        END
                        ELSE true
                    END;
        ');

        $this->addSql('
             CREATE OR REPLACE VIEW imobiliario.vw_construcao_outros AS
             SELECT DISTINCT ON (ct.cod_construcao) ct.cod_construcao,
                ct.descricao,
                ac."timestamp",
                cp.cod_processo,
                cp.exercicio,
                dc.data_construcao,
                COALESCE(to_char(bc.dt_inicio::timestamp with time zone, \'DD/MM/YYYY\'::text), NULL::text) AS data_baixa,
                COALESCE(bc.justificativa, NULL::text) AS justificativa,
                bc."timestamp" AS timestamp_baixa,
                    CASE
                        WHEN bc.dt_inicio IS NULL OR bc.dt_inicio IS NOT NULL AND bc.dt_termino IS NOT NULL THEN \'Ativo\'::text
                        ELSE \'Baixado\'::text
                    END AS situacao,
                    CASE
                        WHEN ud.inscricao_municipal IS NOT NULL THEN ud.inscricao_municipal
                        ELSE cd.cod_condominio
                    END AS imovel_cond,
                    CASE
                        WHEN cd.cod_condominio IS NOT NULL THEN cd.nom_condominio
                        ELSE NULL::character varying
                    END AS nom_condominio,
                    CASE
                        WHEN ud.inscricao_municipal::character varying IS NOT NULL THEN \'Dependente\'::text
                        ELSE \'Condomínio\'::text
                    END AS tipo_vinculo,
                    CASE
                        WHEN ud.inscricao_municipal::character varying IS NOT NULL THEN aud.area
                        ELSE ac.area_real
                    END AS area_real
               FROM imobiliario.construcao_outros ct
                 LEFT JOIN ( SELECT bal.cod_construcao,
                        bal."timestamp",
                        bal.justificativa,
                        bal.sistema,
                        bal.justificativa_termino,
                        bal.dt_inicio,
                        bal.dt_termino
                       FROM imobiliario.baixa_construcao bal,
                        ( SELECT max(baixa_construcao."timestamp") AS "timestamp",
                                baixa_construcao.cod_construcao
                               FROM imobiliario.baixa_construcao
                              GROUP BY baixa_construcao.cod_construcao) bt
                      WHERE bal.cod_construcao = bt.cod_construcao AND bal."timestamp" = bt."timestamp") bc ON ct.cod_construcao = bc.cod_construcao
                 LEFT JOIN imobiliario.data_construcao dc ON dc.cod_construcao = ct.cod_construcao
                 LEFT JOIN ( SELECT ac_1.cod_construcao,
                        ac_1."timestamp",
                        ac_1.area_real
                       FROM imobiliario.area_construcao ac_1,
                        ( SELECT max(area_construcao."timestamp") AS "timestamp",
                                area_construcao.cod_construcao
                               FROM imobiliario.area_construcao
                              GROUP BY area_construcao.cod_construcao) mac
                      WHERE ac_1.cod_construcao = mac.cod_construcao AND ac_1."timestamp" = mac."timestamp") ac ON ct.cod_construcao = ac.cod_construcao
                 LEFT JOIN imobiliario.construcao_processo cp ON ct.cod_construcao = cp.cod_construcao
                 LEFT JOIN imobiliario.unidade_dependente ud ON ct.cod_construcao = ud.cod_construcao_dependente
                 LEFT JOIN ( SELECT aud_1.inscricao_municipal,
                        aud_1.cod_construcao_dependente,
                        aud_1.cod_tipo,
                        aud_1.cod_construcao,
                        aud_1."timestamp",
                        aud_1.area
                       FROM imobiliario.area_unidade_dependente aud_1,
                        ( SELECT max(area_unidade_dependente."timestamp") AS "timestamp",
                                area_unidade_dependente.cod_construcao_dependente
                               FROM imobiliario.area_unidade_dependente
                              GROUP BY area_unidade_dependente.cod_construcao_dependente) maud
                      WHERE aud_1.cod_construcao_dependente = maud.cod_construcao_dependente AND aud_1."timestamp" = maud."timestamp") aud ON ct.cod_construcao = aud.cod_construcao_dependente
                 LEFT JOIN ( SELECT cc.cod_construcao,
                        cd_1.cod_condominio,
                        cd_1.cod_tipo,
                        cd_1.nom_condominio,
                        cd_1."timestamp"
                       FROM imobiliario.construcao_condominio cc,
                        imobiliario.condominio cd_1
                      WHERE cd_1.cod_condominio = cc.cod_condominio) cd ON ct.cod_construcao = cd.cod_construcao
              ORDER BY ct.cod_construcao;
        ');

        $this->insertRoute('urbem_tributario_imobiliario_condominio_list', 'Cadastro Imobiliário - Condomínio', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_create', 'Incluir', 'urbem_tributario_imobiliario_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_edit', 'Alterar', 'urbem_tributario_imobiliario_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_delete', 'Excluir', 'urbem_tributario_imobiliario_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_show', 'Detalhe', 'urbem_tributario_imobiliario_condominio_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
