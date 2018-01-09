<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161130130332 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.cbo_cod_cbo_seq");
        $this->addSql("CREATE SEQUENCE pessoal.cbo_cod_cbo_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.cbo_cod_cbo_seq',
            COALESCE((SELECT MAX(cod_cbo) + 1 
                      FROM pessoal.cbo), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.cbo_cod_cbo_seq");
    }
}
