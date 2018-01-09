<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161207161401 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.caso_causa_cod_caso_causa_seq");
        $this->addSql("CREATE SEQUENCE pessoal.caso_causa_cod_caso_causa_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.caso_causa_cod_caso_causa_seq',
            COALESCE((SELECT MAX(cod_caso_causa) + 1
                      FROM pessoal.caso_causa), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.caso_causa_cod_caso_causa_seq");
    }
}
