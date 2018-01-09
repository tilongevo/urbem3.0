<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161130172315 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS beneficio.linha_cod_linha_seq");
        $this->addSql("CREATE SEQUENCE beneficio.linha_cod_linha_seq START 1");

        $this->addSql("SELECT setval(
            'beneficio.linha_cod_linha_seq',
            COALESCE((SELECT MAX(cod_linha) + 1 
                      FROM beneficio.linha), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS beneficio.linha_cod_linha_seq");
    }
}
