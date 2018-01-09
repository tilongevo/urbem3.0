<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170103183022 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql(
            "
            CREATE TABLE IF NOT EXISTS folhapagamento.sindicato_funcao (
                numcgm int4 NOT NULL,
                cod_funcao int4 NOT NULL,
                cod_modulo int4 NOT NULL,
                cod_biblioteca int4 NOT NULL,
                CONSTRAINT pk_sindicato_funcao PRIMARY KEY (
                    numcgm ),
                CONSTRAINT fk_sindicato_funcao_1 FOREIGN KEY (
                    numcgm )
                REFERENCES folhapagamento.sindicato (
                    numcgm ),
                CONSTRAINT fk_sindicato_funcao_2 FOREIGN KEY (
                    cod_modulo,
                    cod_biblioteca,
                    cod_funcao )
                REFERENCES administracao.funcao (
                    cod_modulo,
                    cod_biblioteca,
                    cod_funcao ) )
            WITH (
                OIDS = TRUE );
            "
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
