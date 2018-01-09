<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161121180846 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.situacao_bem_seq");
                $this->addSql("CREATE SEQUENCE patrimonio.situacao_bem_seq START 1");
                $this->addSql("SELECT setval(
            'patrimonio.situacao_bem_seq',
            COALESCE((SELECT MAX(cod_situacao)+1 FROM patrimonio.situacao_bem), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.situacao_bem_seq");
    }
}
