<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161207161846 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.caso_causa_sub_divisao_cod_sub_divisao_seq");
        $this->addSql("CREATE SEQUENCE pessoal.caso_causa_sub_divisao_cod_sub_divisao_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.caso_causa_sub_divisao_cod_sub_divisao_seq',
            COALESCE((SELECT MAX(cod_sub_divisao) + 1
                      FROM pessoal.caso_causa_sub_divisao), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.caso_causa_sub_divisao_cod_sub_divisao_seq");
    }
}
