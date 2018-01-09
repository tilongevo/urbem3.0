<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191041 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // Se tabela existir ignora
        $conn = $this->connection;

        $sth = $conn->prepare("SELECT COUNT(*) as total FROM INFORMATION_SCHEMA.COLUMNS t where t.table_schema = 'administracao' and t.table_name = 'rota'");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_CLASS);
        $result = array_shift($result);

        if ($result->total == 0) {
            // Cria rotas
            $this->addSql('CREATE TABLE administracao.rota (
                        cod_rota integer NOT NULL,
                        descricao_rota character varying(255) NOT NULL,
                        traducao_rota character varying(255) NOT NULL,
                        rota_superior character varying(255) DEFAULT NULL::character varying,
                        relatorio boolean DEFAULT false NOT NULL
                    )');

            $this->addSql('ALTER TABLE ONLY administracao.rota ADD CONSTRAINT rota_pkey PRIMARY KEY (cod_rota)');
            $this->addSql('CREATE INDEX cod_rota_idx ON administracao.rota USING btree (cod_rota)');
            $this->addSql('CREATE INDEX descricao_rota_idx ON administracao.rota USING btree (descricao_rota)');

            $this->addSql("CREATE SEQUENCE administracao.rota_cod_rota_seq START 1");
            $this->addSql("SELECT setval(
                'administracao.rota_cod_rota_seq',
                COALESCE((SELECT MAX(cod_rota) + 1
                          FROM administracao.rota), 1),
                FALSE
            );");
            $this->addSql("ALTER TABLE ONLY administracao.rota ALTER COLUMN cod_rota SET DEFAULT nextval('administracao.rota_cod_rota_seq'::regclass)");

            // Cria grupos
            $this->addSql('CREATE TABLE administracao.grupo (
                        cod_grupo integer NOT NULL,
                        nom_grupo character varying(255) NOT NULL,
                        desc_grupo character varying(255) NOT NULL,
                        ativo boolean
                    )');
            $this->addSql('ALTER TABLE ONLY administracao.grupo ADD CONSTRAINT grupo_pkey PRIMARY KEY (cod_grupo)');

            $this->addSql("CREATE SEQUENCE administracao.grupo_cod_grupo_seq START 1");
            $this->addSql("SELECT setval(
                'administracao.grupo_cod_grupo_seq',
                COALESCE((SELECT MAX(cod_grupo) + 1
                          FROM administracao.grupo), 1),
                FALSE
            );");
            $this->addSql("ALTER TABLE ONLY administracao.grupo ALTER COLUMN cod_grupo SET DEFAULT nextval('administracao.grupo_cod_grupo_seq'::regclass)");
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP SEQUENCE IF EXISTS administracao.rota_cod_rota_seq");
        $this->addSql("DROP SEQUENCE IF EXISTS administracao.grupo_cod_grupo_seq");
        $this->addSql("DROP TABLE IF EXISTS administracao.rota");
        $this->addSql("DROP TABLE IF EXISTS administracao.grupo");
    }
}
