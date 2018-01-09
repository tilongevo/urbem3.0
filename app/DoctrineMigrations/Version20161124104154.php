<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161124104154 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.almoxarifado_seq");
        $this->addSql("CREATE SEQUENCE almoxarifado.almoxarifado_seq START 1");

        $this->addSql("SELECT setval(
            'almoxarifado.almoxarifado_seq',
            COALESCE((SELECT MAX(cod_almoxarifado) + 1
                      FROM almoxarifado.almoxarifado), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.almoxarifado_seq");
    }
}
