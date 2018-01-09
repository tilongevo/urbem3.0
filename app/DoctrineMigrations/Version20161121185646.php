<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161121185646 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS administracao.auditoria_seq CASCADE");
        $this->addSql("CREATE SEQUENCE administracao.auditoria_seq START 1");
        $this->addSql("SELECT setval(
            'administracao.auditoria_seq',
            COALESCE((SELECT MAX(id)+1 FROM administracao.auditoria), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS administracao.auditoria_seq");
    }
}
