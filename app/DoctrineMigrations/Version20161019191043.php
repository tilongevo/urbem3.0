<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191043 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // Se tabela existir ignora
        $conn = $this->connection;

        $sth = $conn->prepare("SELECT COUNT(*) as total FROM INFORMATION_SCHEMA.COLUMNS t where t.table_schema = 'administracao' and t.table_name = 'grupo_usuario'");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_CLASS);
        $result = array_shift($result);

        if ($result->total == 0) {
            // Adiciona grupo_usuario
            $this->addSql('CREATE TABLE administracao.grupo_usuario (
                        cod_grupo integer NOT NULL,
                        cod_usuario integer NOT NULL
                    );');
            $this->addSql('ALTER TABLE ONLY administracao.grupo_usuario ADD CONSTRAINT grupo_usuario_pkey PRIMARY KEY (cod_grupo, cod_usuario)');
            $this->addSql('CREATE INDEX idx_fcc5b1f34221a5c2 ON administracao.grupo_usuario USING btree (cod_grupo)');
            $this->addSql('CREATE INDEX idx_fcc5b1f3b0dd40c9 ON administracao.grupo_usuario USING btree (cod_usuario)');
            $this->addSql('ALTER TABLE ONLY administracao.grupo_usuario ADD CONSTRAINT fk_fcc5b1f34221a5c2 FOREIGN KEY (cod_grupo) REFERENCES administracao.grupo(cod_grupo)');
            $this->addSql('ALTER TABLE ONLY administracao.grupo_usuario ADD CONSTRAINT fk_fcc5b1f3b0dd40c9 FOREIGN KEY (cod_usuario) REFERENCES administracao.usuario(id);');


            // Adiciona grupo_permissao
            $this->addSql('CREATE TABLE administracao.grupo_permissao (
                        cod_grupo integer NOT NULL,
                        cod_rota integer NOT NULL
                    );');
            $this->addSql('CREATE INDEX idx_1c4b311b4221a5c2 ON administracao.grupo_permissao USING btree (cod_grupo)');
            $this->addSql('CREATE INDEX idx_1c4b311b9cc5585d ON administracao.grupo_permissao USING btree (cod_rota)');
            $this->addSql('ALTER TABLE ONLY administracao.grupo_permissao ADD CONSTRAINT fk_1c4b311b4221a5c2 FOREIGN KEY (cod_grupo) REFERENCES administracao.grupo(cod_grupo)');
            $this->addSql('ALTER TABLE ONLY administracao.grupo_permissao ADD CONSTRAINT fk_1c4b311b9cc5585d FOREIGN KEY (cod_rota) REFERENCES administracao.rota(cod_rota)');
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
