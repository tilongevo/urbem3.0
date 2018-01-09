<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161215103230 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.classificacao_assentamento_cod_classificacao_seq");
        $this->addSql("CREATE SEQUENCE pessoal.classificacao_assentamento_cod_classificacao_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.classificacao_assentamento_cod_classificacao_seq',
            COALESCE((SELECT MAX(cod_classificacao) + 1
                      FROM pessoal.classificacao_assentamento), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.classificacao_assentamento_cod_classificacao_seq");
    }
}
