<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201164539 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.localizacao_fisica_cod_localizacao_seq");
        $this->addSql("CREATE SEQUENCE almoxarifado.localizacao_fisica_cod_localizacao_seq START 1");

        $this->addSql("SELECT setval(
            'almoxarifado.localizacao_fisica_cod_localizacao_seq',
            COALESCE((SELECT MAX(cod_localizacao) + 1 FROM almoxarifado.localizacao_fisica), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS almoxarifado.todos_empenhos_id_seq");
    }
}
