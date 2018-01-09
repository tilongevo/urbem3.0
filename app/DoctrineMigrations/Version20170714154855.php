<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170714154855 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute("prestacao_contas_stn_rreo");
        $this->removeRoute("prestacao_contas_stn_rgf");
        $this->removeRoute("prestacao_contas_stn_amf");
        $this->removeRoute("prestacao_contas_stn_arf");

        $this->insertRoute('prestacao_contas_stn_dinamico', 'STN', 'prestacao_contas');
        $this->insertRoute('prestacao_contas_relatorio_stn_create', 'Relatório', 'prestacao_contas_stn_dinamico');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
