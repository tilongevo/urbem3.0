<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161122103342 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.tipo_baixa_seq");
        $this->addSql("CREATE SEQUENCE patrimonio.tipo_baixa_seq START 1");

        $this->addSql("SELECT setval(
            'patrimonio.tipo_baixa_seq',
            COALESCE((SELECT MAX(cod_tipo)+1 FROM patrimonio.tipo_baixa), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.tipo_baixa_seq");
    }
}
