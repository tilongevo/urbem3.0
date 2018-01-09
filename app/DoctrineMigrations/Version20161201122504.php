<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201122504 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.vinculo_empregaticio_cod_vinculo_seq");
        $this->addSql("CREATE SEQUENCE pessoal.vinculo_empregaticio_cod_vinculo_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.vinculo_empregaticio_cod_vinculo_seq',
            COALESCE((SELECT MAX(cod_vinculo) + 1
                      FROM pessoal.vinculo_empregaticio), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.vinculo_empregaticio_cod_vinculo_seq");
    }
}
