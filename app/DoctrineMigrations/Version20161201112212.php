<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201112212 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */

    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.tipo_admissao_cod_tipo_admissao_seq");
        $this->addSql("CREATE SEQUENCE pessoal.tipo_admissao_cod_tipo_admissao_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.tipo_admissao_cod_tipo_admissao_seq',
            COALESCE((SELECT MAX(cod_tipo_admissao) + 1
                      FROM pessoal.tipo_admissao), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.tipo_admissao_cod_tipo_admissao_seq");
    }
}
