<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161206094707 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS folhapagamento.vinculo_cod_vinculo_seq");
        $this->addSql("CREATE SEQUENCE folhapagamento.vinculo_cod_vinculo_seq START 1");

        $this->addSql("SELECT setval(
            'folhapagamento.vinculo_cod_vinculo_seq',
            COALESCE((SELECT MAX(cod_vinculo) + 1
                      FROM folhapagamento.vinculo), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS folhapagamento.vinculo_cod_vinculo_seq");
    }
}
