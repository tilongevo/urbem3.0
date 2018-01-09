<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170705182124 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP SEQUENCE prestacao_contas.fila_relatorio_id_seq");
        $this->addSql("DROP TABLE prestacao_contas.fila_relatorio");
        $this->addSql("DROP SCHEMA prestacao_contas");

        $this->addSql("CREATE SCHEMA prestacao_contas;");
        $this->addSql("CREATE SEQUENCE prestacao_contas.fila_relatorio_id_seq INCREMENT BY 1 MINVALUE 1 START 1;");
        $this->addSql("CREATE TABLE prestacao_contas.fila_relatorio (
            id INT NOT NULL,
            cod_usuario INT DEFAULT NULL,
            relatorio TEXT NOT NULL,
            parametros TEXT NOT NULL,
            resposta TEXT DEFAULT NULL,
            status VARCHAR (30) NOT NULL,
            data_criacao TIMESTAMP NOT NULL,
            data_resposta TIMESTAMP DEFAULT NULL,
            PRIMARY KEY(id)
        );");

        $this->addSql("COMMENT ON COLUMN prestacao_contas.fila_relatorio.parametros IS '(DC2Type:json_array)'");
        $this->addSql("COMMENT ON COLUMN prestacao_contas.fila_relatorio.resposta IS '(DC2Type:json_array)'");
        $this->addSql("COMMENT ON COLUMN prestacao_contas.fila_relatorio.data_criacao IS '(DC2Type:datetimepk)'");
        $this->addSql("COMMENT ON COLUMN prestacao_contas.fila_relatorio.data_resposta IS '(DC2Type:datetimepk)'");

        $this->addSql("ALTER TABLE prestacao_contas.fila_relatorio ADD CONSTRAINT FK_D6E84F3EB9EE40C9 FOREIGN KEY (cod_usuario) REFERENCES administracao.usuario (numcgm) NOT DEFERRABLE INITIALLY IMMEDIATE;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
