<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelLote;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170504135918 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_max_imovel_lote;');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_imovel_ativo;');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_matricula_imovel_atual;');
        $this->changeColumnToDateTimeMicrosecondType(Imovel::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ImovelLote::class, 'timestamp');
        $this->insertRoute('urbem_tributario_imobiliario_lote_aglutinar_create', 'Aglutinar', 'urbem_tributario_imobiliario_lote_list');
        $this->addSql('
            CREATE OR REPLACE VIEW imobiliario.vw_max_imovel_lote AS
                 SELECT il.inscricao_municipal,
                    il.cod_lote,
                    il."timestamp"
                   FROM imobiliario.imovel_lote il,
                    ( SELECT max(il_1."timestamp") AS "timestamp",
                            il_1.inscricao_municipal
                           FROM imobiliario.imovel_lote il_1
                          GROUP BY il_1.inscricao_municipal) mil
                  WHERE il.inscricao_municipal = mil.inscricao_municipal AND il."timestamp" = mil."timestamp";
        ');
        $this->addSql('
            CREATE OR REPLACE VIEW imobiliario.vw_matricula_imovel_atual AS
                 SELECT matricula_imovel.inscricao_municipal,
                    matricula_imovel."timestamp",
                    matricula_imovel.mat_registro_imovel,
                    matricula_imovel.zona
                   FROM imobiliario.matricula_imovel,
                    ( SELECT matricula_imovel_1.inscricao_municipal,
                            max(matricula_imovel_1."timestamp") AS "timestamp"
                           FROM imobiliario.matricula_imovel matricula_imovel_1
                          GROUP BY matricula_imovel_1.inscricao_municipal) max_matricula_imovel
                  WHERE matricula_imovel.inscricao_municipal = max_matricula_imovel.inscricao_municipal AND matricula_imovel."timestamp" = max_matricula_imovel."timestamp";
        ');
        $this->addSql('
            CREATE OR REPLACE VIEW imobiliario.vw_imovel_ativo AS
                 SELECT i.inscricao_municipal,
                    iil.cod_lote,
                    i.cod_sublote,
                    ( SELECT max(imovel_lote."timestamp") AS max
                           FROM imobiliario.imovel_lote) AS "timestamp",
                    i.dt_cadastro
                   FROM imobiliario.imovel i
                     LEFT JOIN ( SELECT bal.inscricao_municipal,
                            bal."timestamp",
                            bal.justificativa,
                            bal.justificativa_termino,
                            bal.dt_inicio,
                            bal.dt_termino
                           FROM imobiliario.baixa_imovel bal,
                            ( SELECT max(baixa_imovel."timestamp") AS "timestamp",
                                    baixa_imovel.inscricao_municipal
                                   FROM imobiliario.baixa_imovel
                                  GROUP BY baixa_imovel.inscricao_municipal) bt
                          WHERE bal.inscricao_municipal = bt.inscricao_municipal AND bal."timestamp" = bt."timestamp") bi ON i.inscricao_municipal = bi.inscricao_municipal
                     JOIN ( SELECT iil_1.inscricao_municipal,
                            iil_1."timestamp",
                            iil_1.cod_lote
                           FROM imobiliario.imovel_lote iil_1,
                            ( SELECT max(imovel_lote."timestamp") AS "timestamp",
                                    imovel_lote.inscricao_municipal
                                   FROM imobiliario.imovel_lote
                                  GROUP BY imovel_lote.inscricao_municipal) il
                          WHERE iil_1.inscricao_municipal = il.inscricao_municipal AND iil_1."timestamp" = il."timestamp") iil ON i.inscricao_municipal = iil.inscricao_municipal
                  WHERE bi.dt_inicio IS NULL OR bi.dt_inicio IS NOT NULL AND bi.dt_termino IS NOT NULL AND bi.inscricao_municipal = i.inscricao_municipal;
        ');
        $this->addSql('
                CREATE OR REPLACE FUNCTION imobiliario.fn_recupera_lote_proprietarios(integer)
                 RETURNS SETOF record
                 LANGUAGE plpgsql
                AS $function$
                DECLARE
                    inCodLote       ALIAS FOR $1;
                    stNovoSql       VARCHAR   := \'\';
                    stSql           VARCHAR   := \'\';
                    inCount         INTEGER   :=0;
                    reRegistro      RECORD;
                    reRegistroProp  RECORD;
                
                BEGIN
                    stSql := \'
                            SELECT DISTINCT
                                IL.cod_lote,
                                IL.inscricao_municipal
                            FROM
                                imobiliario.imovel_lote IL
                            LEFT JOIN
                                imobiliario.baixa_imovel BI
                            ON
                                BI.inscricao_municipal = IL.inscricao_municipal
                            WHERE
                                BI.inscricao_municipal IS NULL AND
                                IL.cod_lote = \'||inCodLote||\'
                             \';
                
                
                    FOR reRegistro IN EXECUTE stSql LOOP
                       stNovoSql := \'
                                SELECT
                                    numcgm
                                FROM
                                    imobiliario.proprietario
                                WHERE
                                    inscricao_municipal = \'||reRegistro.inscricao_municipal||\' AND
                                    promitente          = false
                                \';
                        FOR reRegistroProp IN EXECUTE stNovoSql LOOP
                            RETURN next reRegistroProp;
                        END LOOP;
                
                --        RETURN next reRegistro;
                    END LOOP;
                
                    RETURN;
                
                END;
                $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DELETE FUNCTION IF EXISTS imobiliario.fn_recupera_lote_proprietarios(integer);');
    }
}
