<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161205164906 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.cod_centro_seq");
        $this->addSql("CREATE SEQUENCE almoxarifado.cod_centro_seq");

        $this->addSql("SELECT setval(
            'almoxarifado.cod_centro_seq',
            COALESCE((SELECT MAX(cod_centro) + 1 FROM almoxarifado.centro_custo), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.cod_centro_seq");
    }
}
