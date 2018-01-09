<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161124111503 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS sw_processo_cod_processo_seq");
        $this->addSql("CREATE SEQUENCE sw_processo_cod_processo_seq START 1");

        $this->addSql("SELECT setval(
            'sw_processo_cod_processo_seq',
            COALESCE((SELECT MAX(cod_processo)+1 FROM sw_processo), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE sw_processo_cod_processo_seq CASCADE');
    }
}
