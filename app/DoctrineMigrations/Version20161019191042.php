<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191042 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // Se tabela existir com mesmo número de colunas ignora
        $conn = $this->connection;

        $sth = $conn->prepare("SELECT COUNT(*) as total FROM INFORMATION_SCHEMA.COLUMNS t where t.table_schema = 'administracao' and t.table_name = 'usuario'");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_CLASS);
        $result = array_shift($result);
        $numeroColunasTabelaUsuario = 19;

        if ($result->total < $numeroColunasTabelaUsuario) {
            // Adiciona colunas em usuários
            $this->addSql('ALTER TABLE administracao.usuario ADD email VARCHAR(180) DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD id INT DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD username_canonical VARCHAR(180) DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD email_canonical VARCHAR(180) DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD enabled BOOLEAN DEFAULT TRUE');
            $this->addSql('ALTER TABLE administracao.usuario ADD salt VARCHAR(255) DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD locked BOOLEAN DEFAULT FALSE');
            $this->addSql('ALTER TABLE administracao.usuario ADD confirmation_token VARCHAR(255) DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD roles TEXT DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
            $this->addSql('ALTER TABLE administracao.usuario ADD credentials_expire_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
            $this->addSql("ALTER TABLE administracao.usuario ALTER COLUMN password TYPE character varying(255)");
            $this->addSql("UPDATE pg_attribute SET atttypmod = 250+4 WHERE attrelid = 'administracao.usuario'::regclass AND attname = 'username';");

            $this->addSql('UPDATE administracao.usuario SET id = numcgm');
            $this->addSql("UPDATE administracao.usuario SET email = username || '@email.com'");
            $this->addSql("UPDATE administracao.usuario SET salt = 'CGQ5wqL7VEr[<(rF,4~CZX5#'");
            $this->addSql("UPDATE administracao.usuario SET password = '$2y$13\$AE2y4lRS25FQobHTu1vSpu4YEKNZXBvbPPYj6TD9bBDBFvNhEzAdG'");
            $this->addSql("UPDATE administracao.usuario SET email_canonical = email");
            $this->addSql("UPDATE administracao.usuario SET username_canonical = username");

            $this->addSql("CREATE SEQUENCE administracao.usuario_id_seq START 1");
            $this->addSql("SELECT setval(
                'administracao.usuario_id_seq',
                COALESCE((SELECT MAX(id) + 1
                          FROM administracao.usuario), 1),
                FALSE
            );");

            $this->addSql("ALTER TABLE ONLY administracao.usuario ALTER COLUMN id SET DEFAULT nextval('administracao.usuario_id_seq'::regclass)");
            $this->addSql("ALTER TABLE ONLY administracao.usuario DROP CONSTRAINT pk_usuario CASCADE");
            $this->addSql("ALTER TABLE ONLY administracao.usuario ADD CONSTRAINT usuario_pkey PRIMARY KEY (id)");
            $this->addSql("ALTER TABLE ONLY administracao.usuario ADD CONSTRAINT fk_usuario_".uniqid()." FOREIGN KEY (cod_orgao) REFERENCES organograma.orgao(cod_orgao);");
        }

        $this->addSql("UPDATE administracao.usuario SET roles = 'a:2:{i:0;s:10:\"ROLE_ADMIN\";i:1;s:16:\"ROLE_SUPER_ADMIN\";}'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
//        $this->addSql("DROP SEQUENCE IF EXISTS administracao.usuario_id_seq");
    }
}
