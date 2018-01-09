<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191045 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // Se tabela existir com mesmo número de colunas ignora
        $conn = $this->connection;

        $sth = $conn->prepare("SELECT COUNT(*) as total FROM INFORMATION_SCHEMA.COLUMNS t where t.table_schema = 'administracao' and t.table_name = 'auditoria'");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_CLASS);
        $result = array_shift($result);
        $numeroColunasTabelaAuditoria = 5;

        if ($result->total == $numeroColunasTabelaAuditoria) {
            $this->addSql("DROP SEQUENCE IF EXISTS administracao.auditoria_seq CASCADE");
            $this->addSql('ALTER TABLE administracao.auditoria RENAME TO "auditoria_old"');

            $this->addSql("CREATE TABLE administracao.auditoria (
                id integer DEFAULT NULL,
                numcgm integer DEFAULT NULL,
                cod_acao integer DEFAULT NULL,
                nomcgm character varying(255) DEFAULT NULL,
                ip character varying(255) DEFAULT NULL,
                rota character varying(255) DEFAULT NULL::character varying,
                modulo character varying(255) DEFAULT NULL,
                submodulo character varying(255) DEFAULT NULL,
                entidade character varying(255) DEFAULT NULL,
                created_at timestamp(0) without time zone DEFAULT NULL,
                timestamp timestamp(0) without time zone DEFAULT NULL,
                transacao BOOLEAN DEFAULT TRUE,
                conteudo character varying(1000) DEFAULT NULL,
                objeto character varying(1000) DEFAULT NULL,
                tipo character varying(1000) DEFAULT NULL
            );");

            $this->addSql("CREATE SEQUENCE administracao.auditoria_seq START 1");
            $this->addSql("SELECT setval(
                'administracao.auditoria_seq',
                COALESCE((SELECT MAX(id) + 1
                          FROM administracao.auditoria), 1),
                FALSE
            );");

            $this->addSql("ALTER TABLE ONLY administracao.auditoria ALTER COLUMN id SET DEFAULT nextval('administracao.auditoria_seq'::regclass)");
            $this->addSql("ALTER TABLE ONLY administracao.auditoria ADD CONSTRAINT pk_auditoria_1 PRIMARY KEY (id)");
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
