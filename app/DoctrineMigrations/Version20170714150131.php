<?php

namespace Application\Migrations;

use PDO;
use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Economico\BaixaLicenca;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170714150131 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $stmt = $this->connection->query('
            SELECT
                table_name
            FROM
                information_schema.views
            WHERE
                table_name IN (\'vw_licenca_suspensa_ativa\', \'vw_licenca_ativa\')
                AND table_schema = \'economico\';
        ');
        $stmt->execute();
        $views = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (in_array('vw_licenca_suspensa_ativa', $views)) {
            $this->addSql('DROP VIEW economico.vw_licenca_suspensa_ativa');
        }

        if (in_array('vw_licenca_ativa', $views)) {
            $this->addSql('DROP VIEW economico.vw_licenca_ativa');
        }

        $this->changeColumnToDateTimeMicrosecondType(BaixaLicenca::class, 'timestamp');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_baixa_licenca_create', 'Baixar Licença', 'tributario_economico_licenca_home');");

        if (in_array('vw_licenca_suspensa_ativa', $views)) {
            $this->addSql('
                CREATE VIEW economico.vw_licenca_suspensa_ativa AS
                    SELECT DISTINCT ON (lc.cod_licenca) lc.cod_licenca,
                        lc.exercicio,
                        lc.dt_inicio,
                        lc.dt_termino,
                        pl.cod_processo,
                        pl.exercicio_processo,
                        CASE
                            WHEN lca.inscricao_economica::text::character varying IS NOT NULL THEN \'Atividade\'::text
                            WHEN lce.inscricao_economica::text::character varying IS NOT NULL THEN \'Especial\'::text
                            WHEN lcd.numcgm::text::character varying IS NOT NULL THEN \'Diversa\'::text
                            ELSE NULL::text
                        END AS especie_licenca,
                        lcd.cod_tipo AS cod_tipo_diversa,
                        CASE
                            WHEN lca.inscricao_economica IS NOT NULL THEN lca.inscricao_economica
                            WHEN lce.inscricao_economica IS NOT NULL THEN lce.inscricao_economica
                            ELSE NULL::integer
                        END AS inscricao_economica,
                        CASE
                            WHEN ceef.inscricao_economica IS NOT NULL THEN ceef.numcgm
                            WHEN ceed.inscricao_economica IS NOT NULL THEN ceed.numcgm
                            WHEN cea.inscricao_economica IS NOT NULL THEN cea.numcgm
                            ELSE lcd.numcgm
                        END AS numcgm,
                        cgm.nom_cgm,
                        pbl.cod_processo AS cod_processo_baixa,
                        pbl.exercicio_processo AS exercicio_processo_baixa,
                        bl.dt_inicio AS dt_susp_inicio,
                        bl.dt_termino AS dt_susp_termino,
                        bl.motivo
                    FROM
                        economico.licenca lc
                    LEFT JOIN
                        (
                            SELECT bl_1.cod_licenca,
                                bl_1.exercicio,
                                bl_1.dt_inicio,
                                bl_1.dt_termino,
                                bl_1.cod_tipo,
                                bl_1."timestamp",
                                bl_1.motivo
                            FROM
                                economico.baixa_licenca bl_1,
                                (
                                    SELECT
                                        baixa_licenca.cod_licenca,
                                        max(baixa_licenca."timestamp") AS "timestamp"
                                    FROM
                                        economico.baixa_licenca
                                    GROUP BY
                                        baixa_licenca.cod_licenca
                                ) ml
                            WHERE
                                bl_1.cod_licenca = ml.cod_licenca
                                AND bl_1."timestamp" = ml."timestamp"
                        ) bl
                        ON
                            lc.cod_licenca = bl.cod_licenca
                            AND lc.exercicio = bl.exercicio
                    LEFT JOIN
                        economico.processo_licenca pl
                        ON
                            lc.cod_licenca = pl.cod_licenca
                            AND lc.exercicio = pl.exercicio
                    LEFT JOIN
                        economico.licenca_atividade lca
                        ON
                            lca.cod_licenca = lc.cod_licenca
                            AND lca.exercicio = lc.exercicio
                    LEFT JOIN
                        economico.licenca_especial lce
                        ON
                            lce.cod_licenca = lc.cod_licenca
                            AND lce.exercicio = lc.exercicio
                    LEFT JOIN
                        economico.licenca_diversa lcd
                        ON
                            lcd.cod_licenca = lc.cod_licenca
                            AND lcd.exercicio = lc.exercicio
                    LEFT JOIN
                        economico.cadastro_economico_empresa_fato ceef
                        ON
                            ceef.inscricao_economica = lca.inscricao_economica
                            OR ceef.inscricao_economica = lce.inscricao_economica
                    LEFT JOIN
                        economico.cadastro_economico_empresa_direito ceed
                        ON
                            ceed.inscricao_economica = lca.inscricao_economica
                            OR ceed.inscricao_economica = lce.inscricao_economica
                    LEFT JOIN
                        economico.cadastro_economico_autonomo cea
                        ON
                            cea.inscricao_economica = lca.inscricao_economica
                            OR cea.inscricao_economica = lce.inscricao_economica
                    LEFT JOIN
                        sw_cgm cgm
                        ON
                            lcd.numcgm = cgm.numcgm
                            OR cea.numcgm = cgm.numcgm
                            OR ceef.numcgm = cgm.numcgm
                            OR ceed.numcgm = cgm.numcgm
                    LEFT JOIN
                        economico.processo_baixa_licenca pbl
                        ON
                            pbl.cod_licenca = lc.cod_licenca
                            AND pbl.exercicio = lc.exercicio
                      WHERE
                        lc.dt_inicio <= now()::date
                        AND CASE
                            WHEN lc.dt_termino IS NOT NULL THEN lc.dt_termino >= now()::date
                            ELSE true
                        END
                        AND CASE
                            WHEN bl.dt_termino IS NOT NULL THEN bl.dt_termino > now()::date
                            ELSE true
                        END
                        AND bl.cod_licenca IS NOT NULL
                        AND bl.cod_tipo = 2
                      ORDER BY
                        lc.cod_licenca
            ');
        }

        if (in_array('vw_licenca_ativa', $views)) {
            $this->addSql('
                CREATE VIEW economico.vw_licenca_ativa AS
                    SELECT
                        DISTINCT ON (lc.cod_licenca, lc.exercicio)
                        lc.cod_licenca,
                        lc.exercicio,
                        lc.dt_inicio,
                        lc.dt_termino,
                        pl.cod_processo,
                        tld.nom_tipo,
                        pl.exercicio_processo,
                        CASE
                            WHEN lca.inscricao_economica::character varying IS NOT NULL THEN \'Atividade\'::text
                            WHEN lce.inscricao_economica::character varying IS NOT NULL THEN \'Especial\'::text
                            WHEN lcd.numcgm::character varying IS NOT NULL THEN \'Diversa\'::text
                            ELSE NULL::text
                        END AS especie_licenca,
                        lcd.cod_tipo AS cod_tipo_diversa,
                        CASE
                            WHEN lca.inscricao_economica IS NOT NULL THEN lca.inscricao_economica
                            WHEN lce.inscricao_economica IS NOT NULL THEN lce.inscricao_economica
                            ELSE NULL::integer
                        END AS inscricao_economica,
                        CASE
                            WHEN ceef.inscricao_economica IS NOT NULL THEN ceef.numcgm
                            WHEN ceed.inscricao_economica IS NOT NULL THEN ceed.numcgm
                            WHEN cea.inscricao_economica IS NOT NULL THEN cea.numcgm
                            ELSE lcd.numcgm
                        END AS numcgm,
                        cgm.nom_cgm
                        FROM economico.licenca lc
                        LEFT JOIN
                            (
                                SELECT bl_1.cod_licenca,
                                    bl_1.exercicio,
                                    bl_1.dt_inicio,
                                    bl_1.dt_termino,
                                    bl_1.cod_tipo,
                                    bl_1."timestamp",
                                    bl_1.motivo
                                FROM economico.baixa_licenca bl_1,
                                (
                                    SELECT
                                        baixa_licenca.cod_licenca,
                                        max(baixa_licenca."timestamp") AS "timestamp"
                                    FROM
                                        economico.baixa_licenca
                                    GROUP BY
                                    baixa_licenca.cod_licenca
                                ) ml
                                WHERE
                                    bl_1.cod_licenca = ml.cod_licenca
                                    AND bl_1."timestamp" = ml."timestamp"
                            ) bl
                            ON
                                lc.cod_licenca = bl.cod_licenca
                                AND lc.exercicio = bl.exercicio
                        LEFT JOIN
                            economico.processo_licenca pl
                            ON
                                lc.cod_licenca = pl.cod_licenca
                                AND lc.exercicio = pl.exercicio
                        LEFT JOIN
                            economico.licenca_atividade lca
                            ON
                                lca.cod_licenca = lc.cod_licenca
                                AND lca.exercicio = lc.exercicio
                        LEFT JOIN
                            economico.licenca_especial lce
                            ON
                                lce.cod_licenca = lc.cod_licenca
                                AND lce.exercicio = lc.exercicio
                        LEFT JOIN
                            economico.licenca_diversa lcd
                            ON
                                lcd.cod_licenca = lc.cod_licenca
                                AND lcd.exercicio = lc.exercicio
                        LEFT JOIN
                            economico.tipo_licenca_diversa tld
                            ON
                                lcd.cod_tipo = tld.cod_tipo
                        LEFT JOIN
                            economico.cadastro_economico_empresa_fato ceef
                            ON
                                ceef.inscricao_economica = lca.inscricao_economica
                                OR ceef.inscricao_economica = lce.inscricao_economica
                        LEFT JOIN
                            economico.cadastro_economico_empresa_direito ceed
                            ON
                                ceed.inscricao_economica = lca.inscricao_economica
                                OR ceed.inscricao_economica = lce.inscricao_economica
                        LEFT JOIN
                            economico.cadastro_economico_autonomo cea
                            ON
                                cea.inscricao_economica = lca.inscricao_economica
                                OR cea.inscricao_economica = lce.inscricao_economica
                        LEFT JOIN
                            sw_cgm cgm
                            ON
                                lcd.numcgm = cgm.numcgm
                                OR cea.numcgm = cgm.numcgm
                                OR ceef.numcgm = cgm.numcgm
                                OR ceed.numcgm = cgm.numcgm
                        WHERE
                            lc.dt_inicio <= now()::date
                            AND CASE
                                WHEN lc.dt_termino IS NOT NULL AND lc.dt_termino <= now()::date THEN false
                                ELSE true
                            END
                            AND CASE
                                WHEN bl.cod_licenca IS NOT NULL THEN
                                    CASE
                                        WHEN bl.cod_tipo = 2 THEN
                                            CASE
                                                WHEN bl.dt_termino IS NULL THEN false
                                                WHEN bl.dt_termino IS NOT NULL AND bl.dt_termino > now()::date THEN false
                                                ELSE true
                                            END
                                        ELSE false
                                    END
                                ELSE true
                            END
                        ORDER BY
                            lc.cod_licenca, lc.exercicio
            ');
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
