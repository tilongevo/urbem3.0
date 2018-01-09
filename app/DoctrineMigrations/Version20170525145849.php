<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170525145849 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.arquivo_coletora_seq CASCADE");
        $this->addSql("CREATE SEQUENCE patrimonio.arquivo_coletora_seq START 1");
        $this->addSql("SELECT setval(
            'patrimonio.arquivo_coletora_seq',
            COALESCE((SELECT MAX(codigo)+1 FROM patrimonio.arquivo_coletora), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
