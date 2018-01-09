<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161130163546 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.categoria_cod_categoria_seq");
        $this->addSql("CREATE SEQUENCE pessoal.categoria_cod_categoria_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.categoria_cod_categoria_seq',
            COALESCE((SELECT MAX(cod_categoria) + 1 
                      FROM pessoal.categoria), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.categoria_cod_categoria_seq");
    }
}
