<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161124113902 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.marca_seq");
        $this->addSql("CREATE SEQUENCE almoxarifado.marca_seq START 1");

        $this->addSql("SELECT setval(
            'almoxarifado.marca_seq',
            COALESCE((SELECT MAX(cod_marca) + 1
                      FROM almoxarifado.marca), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.marca_seq");
    }
}
