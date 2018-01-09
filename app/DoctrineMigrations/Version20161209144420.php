<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161209144420 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.aposentadoria_cod_contrato_seq");
        $this->addSql("CREATE SEQUENCE pessoal.aposentadoria_cod_contrato_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.aposentadoria_cod_contrato_seq',
            COALESCE((SELECT MAX(cod_contrato) + 1
                      FROM pessoal.aposentadoria), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.aposentadoria_cod_contrato_seq");
    }
}
