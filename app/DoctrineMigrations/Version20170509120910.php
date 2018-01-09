<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170509120910 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_unidades;');
        $this->changeColumnToDateTimeMicrosecondType(UnidadeAutonoma::class, 'timestamp');
        $this->addSql('
            CREATE OR REPLACE VIEW imobiliario.vw_unidades AS
                 SELECT uni.inscricao_municipal,
                    uni.cod_tipo,
                    uni.cod_tipo_dependente,
                    uni.cod_construcao,
                    uni."timestamp",
                    uni.cod_construcao_dependente,
                    uni.area,
                    uni.nom_tipo,
                    uni.data_construcao,
                        CASE
                            WHEN uni.cod_construcao_dependente::character varying::text = 0::text THEN \'Autônoma\'::text
                            ELSE \'Dependente\'::text
                        END AS tipo_unidade
                   FROM ( SELECT ua.inscricao_municipal,
                            ua.cod_tipo,
                            ua.cod_tipo AS cod_tipo_dependente,
                            ua.cod_construcao,
                            ua."timestamp",
                            0 AS cod_construcao_dependente,
                            aua.area,
                            te.nom_tipo,
                            to_char(dc.data_construcao::timestamp with time zone, \'DD/MM/YYYY\'::text) AS data_construcao
                           FROM imobiliario.unidade_autonoma ua
                             LEFT JOIN ( SELECT bal.inscricao_municipal,
                                    bal.cod_tipo,
                                    bal.cod_construcao,
                                    bal."timestamp",
                                    bal.justificativa,
                                    bal.justificativa_termino,
                                    bal.dt_inicio,
                                    bal.dt_termino
                                   FROM imobiliario.baixa_unidade_autonoma bal,
                                    ( SELECT max(baixa_unidade_autonoma."timestamp") AS "timestamp",
                                            baixa_unidade_autonoma.inscricao_municipal,
                                            baixa_unidade_autonoma.cod_tipo,
                                            baixa_unidade_autonoma.cod_construcao
                                           FROM imobiliario.baixa_unidade_autonoma
                                          GROUP BY baixa_unidade_autonoma.inscricao_municipal, baixa_unidade_autonoma.cod_tipo, baixa_unidade_autonoma.cod_construcao) bt
                                  WHERE bal.inscricao_municipal = bt.inscricao_municipal AND bal.cod_tipo = bt.cod_tipo AND bal.cod_construcao = bt.cod_construcao AND bal."timestamp" = bt."timestamp") bua ON bua.inscricao_municipal = ua.inscricao_municipal AND bua.cod_tipo = ua.cod_tipo AND bua.cod_construcao = ua.cod_construcao
                             JOIN ( SELECT aua_1.inscricao_municipal,
                                    aua_1.cod_tipo,
                                    aua_1.cod_construcao,
                                    aua_1."timestamp",
                                    aua_1.area
                                   FROM imobiliario.area_unidade_autonoma aua_1,
                                    ( SELECT max(area_unidade_autonoma."timestamp") AS "timestamp",
                                            area_unidade_autonoma.inscricao_municipal
                                           FROM imobiliario.area_unidade_autonoma
                                          GROUP BY area_unidade_autonoma.inscricao_municipal) maua
                                  WHERE aua_1.inscricao_municipal = maua.inscricao_municipal AND aua_1."timestamp" = maua."timestamp") aua ON ua.inscricao_municipal = aua.inscricao_municipal
                             LEFT JOIN imobiliario.tipo_edificacao te ON ua.cod_tipo = te.cod_tipo
                             LEFT JOIN imobiliario.data_construcao dc ON ua.cod_construcao = dc.cod_construcao
                          WHERE bua.dt_inicio IS NULL OR bua.dt_inicio IS NOT NULL AND bua.dt_termino IS NOT NULL AND bua.inscricao_municipal = ua.inscricao_municipal AND bua.cod_tipo = ua.cod_tipo AND bua.cod_construcao = ua.cod_construcao
                        UNION
                         SELECT ud.inscricao_municipal,
                            ud.cod_tipo,
                            ce.cod_tipo AS cod_tipo_dependente,
                            ud.cod_construcao,
                            ud."timestamp",
                            ud.cod_construcao_dependente,
                            aud.area,
                            te.nom_tipo,
                            to_char(dc.data_construcao::timestamp with time zone, \'DD/MM/YYYY\'::text) AS data_construcao
                           FROM imobiliario.construcao_edificacao ce,
                            imobiliario.unidade_dependente ud
                             JOIN imobiliario.vw_max_area_un_dep aud ON ud.inscricao_municipal = aud.inscricao_municipal AND aud.cod_construcao_dependente = ud.cod_construcao_dependente
                             LEFT JOIN ( SELECT bal.inscricao_municipal,
                                    bal.cod_construcao_dependente,
                                    bal.cod_construcao,
                                    bal.cod_tipo,
                                    bal."timestamp",
                                    bal.justificativa,
                                    bal.justificativa_termino,
                                    bal.dt_inicio,
                                    bal.dt_termino
                                   FROM imobiliario.baixa_unidade_dependente bal,
                                    ( SELECT max(baixa_unidade_dependente."timestamp") AS "timestamp",
                                            baixa_unidade_dependente.inscricao_municipal,
                                            baixa_unidade_dependente.cod_tipo,
                                            baixa_unidade_dependente.cod_construcao,
                                            baixa_unidade_dependente.cod_construcao_dependente
                                           FROM imobiliario.baixa_unidade_dependente
                                          GROUP BY baixa_unidade_dependente.inscricao_municipal, baixa_unidade_dependente.cod_tipo, baixa_unidade_dependente.cod_construcao, baixa_unidade_dependente.cod_construcao_dependente) bt
                                  WHERE bal.inscricao_municipal = bt.inscricao_municipal AND bal.cod_tipo = bt.cod_tipo AND bal.cod_construcao = bt.cod_construcao AND bal.cod_construcao_dependente = bt.cod_construcao_dependente AND bal."timestamp" = bt."timestamp") bud ON bud.inscricao_municipal = ud.inscricao_municipal AND bud.cod_tipo = ud.cod_tipo AND bud.cod_construcao = ud.cod_construcao AND bud.cod_construcao_dependente = ud.cod_construcao_dependente
                             LEFT JOIN imobiliario.tipo_edificacao te ON ud.cod_tipo = te.cod_tipo
                             LEFT JOIN imobiliario.data_construcao dc ON dc.cod_construcao = ud.cod_construcao_dependente
                          WHERE aud.inscricao_municipal = ud.inscricao_municipal AND ce.cod_construcao = ud.cod_construcao_dependente AND (bud.dt_inicio IS NULL OR bud.dt_inicio IS NOT NULL AND bud.dt_termino IS NOT NULL AND bud.inscricao_municipal = ud.inscricao_municipal AND bud.cod_tipo = ud.cod_tipo AND bud.cod_construcao = ud.cod_construcao AND bud.cod_construcao_dependente = ud.cod_construcao_dependente)) uni;
        ');
        $this->insertRoute('urbem_tributario_imobiliario_lote_validar_create', 'Validar Lote Desmembrado', 'urbem_tributario_imobiliario_lote_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
