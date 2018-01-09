<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161206172716 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.causa_rescisao_cod_causa_rescisao_seq");
        $this->addSql("CREATE SEQUENCE pessoal.causa_rescisao_cod_causa_rescisao_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.causa_rescisao_cod_causa_rescisao_seq',
            COALESCE((SELECT MAX(cod_causa_rescisao) + 1
                      FROM pessoal.causa_rescisao), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.causa_rescisao_cod_causa_rescisao_seq");
    }
}
