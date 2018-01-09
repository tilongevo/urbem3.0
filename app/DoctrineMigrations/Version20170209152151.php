<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170209152151 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("CREATE SCHEMA rede_simples;");
        $this->addSql("CREATE SEQUENCE rede_simples.protocolo_id_sq INCREMENT BY 1 MINVALUE 1 START 1;");
        $this->addSql("CREATE SEQUENCE rede_simples.protocolo_item_id_sq INCREMENT BY 1 MINVALUE 1 START 1;");
        $this->addSql("CREATE TABLE rede_simples.protocolo (id INT NOT NULL, cod_usuario INT DEFAULT NULL, protocolo VARCHAR(80) DEFAULT NULL, status VARCHAR(80) NOT NULL, retorno VARCHAR(80) DEFAULT NULL, data_criacao DATE NOT NULL, data_ultima_consulta DATE DEFAULT NULL, PRIMARY KEY(id));");
        $this->addSql("CREATE INDEX idx_589c69ff95247 ON rede_simples.protocolo (cod_usuario);");
        $this->addSql("CREATE TABLE rede_simples.protocolo_item (id INT NOT NULL, protocolo_id INT DEFAULT NULL, identificador VARCHAR(40) NOT NULL, campo VARCHAR(40) NOT NULL, tipo VARCHAR(20) NOT NULL, valor TEXT DEFAULT NULL, PRIMARY KEY(id));");
        $this->addSql("CREATE INDEX idx_589c6a0043268 ON rede_simples.protocolo_item (protocolo_id);");

        /** @var \PDO $conn */
        $conn = $this->container->get('doctrine')->getManager()->getConnection();
        $stmt = $conn->prepare(
            'SELECT COUNT(*) 
               FROM pg_indexes
              WHERE schemaname = \'administracao\'
                AND tablename = \'usuario\'
                AND lower(indexdef) LIKE \'%unique%\' AND lower(indexdef) LIKE \'%numcgm%\';'
        );

        $stmt->execute();

        if (0 === (int) $stmt->fetchColumn(0)) {
            $this->addSql("CREATE UNIQUE INDEX uniq_588891600482c ON administracao.usuario (numcgm)");
        }

        $this->addSql("ALTER TABLE rede_simples.protocolo ADD CONSTRAINT FK_D6E84F3EB0DD40C9 FOREIGN KEY (cod_usuario) REFERENCES administracao.usuario (numcgm) NOT DEFERRABLE INITIALLY IMMEDIATE;");
        $this->addSql("ALTER TABLE rede_simples.protocolo_item ADD CONSTRAINT FK_EFCBF8081BEF95598C25956 FOREIGN KEY (protocolo_id) REFERENCES rede_simples.protocolo (id) NOT DEFERRABLE INITIALLY IMMEDIATE;");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'rede_simples', 'Rede Simples', null)");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'rede_simples_protocolo_create', 'Criar Formulário', 'rede_simples')");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'rede_simples_protocolo_list', 'Listar Formulários', 'rede_simples')");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'rede_simples_protocolo_enviar', 'Enviar Formulário', 'rede_simples')");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'rede_simples_protocolo_show', 'Exibir Formulário', 'rede_simples')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP SEQUENCE rede_simples.protocolo_id_sq");
        $this->addSql("DROP SEQUENCE rede_simples.protocolo_item_id_sq");
        $this->addSql("DROP TABLE rede_simples.protocolo_item");
        $this->addSql("DROP TABLE rede_simples.protocolo");
        $this->addSql("DROP SCHEMA rede_simples");
        $this->addSql("DELETE FROM administracao.rota WHERE descricao_rota = 'rede_simples_protocolo_show'");
        $this->addSql("DELETE FROM administracao.rota WHERE descricao_rota = 'rede_simples_protocolo_enviar'");
        $this->addSql("DELETE FROM administracao.rota WHERE descricao_rota = 'rede_simples_protocolo_list'");
        $this->addSql("DELETE FROM administracao.rota WHERE descricao_rota = 'rede_simples_protocolo_create'");
        $this->addSql("DELETE FROM administracao.rota WHERE descricao_rota = 'rede_simples'");
    }
}
