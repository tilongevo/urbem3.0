<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201103214 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.cid_cod_cid_seq");
        $this->addSql("CREATE SEQUENCE pessoal.cid_cod_cid_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.cid_cod_cid_seq',
            COALESCE((SELECT MAX(cod_cid) + 1
                      FROM pessoal.cid), 1),
            FALSE
        );");
    }
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.cid_cod_cid_seq");
    }
}
