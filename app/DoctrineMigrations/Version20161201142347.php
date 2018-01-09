<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201142347 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS folhapagamento.sequencia_seq");
        $this->addSql("CREATE SEQUENCE folhapagamento.sequencia_seq START 1");

        $this->addSql("SELECT setval(
            'folhapagamento.sequencia_seq',
            COALESCE((SELECT MAX(cod_sequencia) + 1
                      FROM folhapagamento.sequencia_calculo), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS folhapagamento.sequencia_seq");
    }
}
