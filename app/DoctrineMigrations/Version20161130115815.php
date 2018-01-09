<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161130115815 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.requisito_cod_requisito_seq");
        $this->addSql("CREATE SEQUENCE pessoal.requisito_cod_requisito_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.requisito_cod_requisito_seq',
            COALESCE((SELECT MAX(cod_requisito) + 1 
                      FROM pessoal.requisito), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.requisito_cod_requisito_seq");
    }
}
