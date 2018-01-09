<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161202163231 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS calendario.feriado_cod_feriado_seq");
        $this->addSql("CREATE SEQUENCE calendario.feriado_cod_feriado_seq START 1");

        $this->addSql("SELECT setval(
            'calendario.feriado_cod_feriado_seq',
            COALESCE((SELECT MAX(cod_feriado) + 1
                      FROM calendario.feriado), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS calendario.feriado_cod_feriado_seq");
    }
}
