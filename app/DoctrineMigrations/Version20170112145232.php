<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170112145232 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP SEQUENCE IF EXISTS licitacao.ata_seq");
        $this->addSql("DROP SEQUENCE IF EXISTS licitacao.publicacao_ata_seq");

        $this->addSql("CREATE SEQUENCE licitacao.ata_seq START 1");
        $this->addSql("CREATE SEQUENCE licitacao.publicacao_ata_seq START 1");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP SEQUENCE IF EXISTS licitacao.ata_seq");
        $this->addSql("DROP SEQUENCE IF EXISTS licitacao.publicacao_ata_seq");
    }
}
