<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelLote;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170530210936 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_imobiliario_transferencia_propriedade_efetivar', 'Efetivar Transferência', 'urbem_tributario_imobiliario_transferencia_propriedade_list');
        $this->addSql("DROP VIEW IF EXISTS imobiliario.vw_max_imovel_lote;");
        $this->addSql('
            DROP VIEW IF EXISTS imobiliario.vw_imovel_ativo;
        ');
        $this->addSql("DROP VIEW IF EXISTS imobiliario.vw_lote_ativo;");

        $this->changeColumnToDateTimeMicrosecondType(Lote::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Imovel::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ImovelLote::class, 'timestamp');

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

        $this->addSql("
            CREATE OR REPLACE VIEW imobiliario.vw_lote_ativo AS
                 SELECT l.cod_lote,
                    l.\"timestamp\",
                    l.dt_inscricao
                   FROM imobiliario.lote l
                     LEFT JOIN ( SELECT bal.cod_lote,
                            bal.\"timestamp\",
                            bal.justificativa,
                            bal.justificativa_termino,
                            bal.dt_inicio,
                            bal.dt_termino
                           FROM imobiliario.baixa_lote bal,
                            ( SELECT max(baixa_lote.\"timestamp\") AS \"timestamp\",
                                    baixa_lote.cod_lote
                                   FROM imobiliario.baixa_lote
                                  GROUP BY baixa_lote.cod_lote) bt
                          WHERE bal.cod_lote = bt.cod_lote AND bal.\"timestamp\" = bt.\"timestamp\") bl ON l.cod_lote = bl.cod_lote
                  WHERE bl.dt_inicio IS NULL OR bl.dt_inicio IS NOT NULL AND bl.dt_termino IS NOT NULL AND bl.cod_lote = l.cod_lote
                  ORDER BY l.cod_lote;
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
