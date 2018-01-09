<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170207164605 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.sefip_cod_sefip_seq");
        $this->addSql("CREATE SEQUENCE pessoal.sefip_cod_sefip_seq START 1");
        $this->addSql("select setval('pessoal.sefip_cod_sefip_seq',coalesce((select max(cod_sefip) + 1 from pessoal.sefip), 1), false);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.sefip_cod_sefip_seq");
    }
}
