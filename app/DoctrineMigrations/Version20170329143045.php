<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170329143045 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("
        SET session_replication_role = REPLICA;
        ");
        $this->addSql("
        ALTER TABLE folhapagamento.pensao_evento DROP CONSTRAINT pk_pensao_evento;
        ");
        $this->addSql("
        ALTER TABLE folhapagamento.pensao_evento DROP CONSTRAINT fk_pensao_evento_3;
        ");
        $this->addSql("
        ALTER TABLE folhapagamento.pensao_funcao_padrao DROP CONSTRAINT pk_pensao_funcao_padrao CASCADE;
        ");
        $this->addSql("
        ALTER TABLE folhapagamento.pensao_evento ALTER COLUMN TIMESTAMP TYPE TIMESTAMP (3)
        USING to_char(TIMESTAMP,
            'YYYY-MM-DD HH24:MI:SS.MS')::TIMESTAMP (3);
        ");
        $this->addSql("
        ALTER TABLE folhapagamento.pensao_funcao_padrao ALTER COLUMN TIMESTAMP TYPE TIMESTAMP (3)
        USING to_char(TIMESTAMP,
            'YYYY-MM-DD HH24:MI:SS.MS')::TIMESTAMP (3);
        ");
        $this->addSql("
        ALTER TABLE folhapagamento.pensao_evento
            ADD CONSTRAINT pk_pensao_evento PRIMARY KEY ( \"timestamp\", cod_tipo, cod_configuracao_pensao );
        ");
        $this->addSql("
        ALTER TABLE folhapagamento.pensao_funcao_padrao
            ADD CONSTRAINT pk_pensao_funcao_padrao PRIMARY KEY ( \"timestamp\", cod_configuracao_pensao );
        ");
        $this->addSql("
        ALTER TABLE folhapagamento.pensao_evento
            ADD CONSTRAINT fk_pensao_evento_3 FOREIGN KEY ( cod_configuracao_pensao, \"timestamp\" ) REFERENCES folhapagamento.pensao_funcao_padrao ( cod_configuracao_pensao, \"timestamp\" );
        ");
        $this->addSql("
        UPDATE
            folhapagamento.pensao_evento
        SET
            \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';
        ");
        $this->addSql("
        UPDATE
            folhapagamento.pensao_funcao_padrao
        SET
            \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';
        ");
        $this->addSql("
        SET session_replication_role = DEFAULT;
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
