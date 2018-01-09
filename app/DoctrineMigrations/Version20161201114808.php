<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201114808 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.conselho_cod_conselho_seq");
        $this->addSql("CREATE SEQUENCE pessoal.conselho_cod_conselho_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.conselho_cod_conselho_seq',
            COALESCE((SELECT MAX(cod_conselho) + 1
                      FROM pessoal.conselho), 1),
            FALSE
        );");
    }
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.conselho_cod_conselho_seq");
    }
}
