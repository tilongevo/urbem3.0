<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161123174330 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.cod_bem_seq");
        $this->addSql("CREATE SEQUENCE patrimonio.cod_bem_seq START 1");

        $this->addSql("SELECT setval(
            'patrimonio.cod_bem_seq',
            COALESCE((SELECT MAX(cod_bem)+1 FROM patrimonio.bem), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.cod_bem_seq");
    }
}
