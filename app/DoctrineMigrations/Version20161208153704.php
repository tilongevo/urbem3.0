<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161208153704 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.grupo_seq");
        $this->addSql("CREATE SEQUENCE patrimonio.grupo_seq START 1");
        $this->addSql("SELECT SETVAL('patrimonio.grupo_seq', COALESCE((SELECT MAX(cod_grupo) + 1 FROM patrimonio.grupo), 1), FALSE);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.grupo_seq");
    }
}
