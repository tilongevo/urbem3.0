<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161128143813 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.cod_item_seq");
        $this->addSql("CREATE SEQUENCE almoxarifado.cod_item_seq START 1");

        $this->addSql("SELECT setval(
            'almoxarifado.cod_item_seq',
            COALESCE((SELECT MAX(cod_item) + 1 
                      FROM almoxarifado.catalogo_item), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.cod_item_seq");
    }
}
