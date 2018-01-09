<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170629175127 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('prestacao_contas_stn_configuracoes', 'STN :: Configurações', 'prestacao_contas');
        $this->insertRoute('prestacao_contas_stn_rreo', 'STN :: RREO', 'prestacao_contas');
        $this->insertRoute('prestacao_contas_stn_rgf', 'STN :: RGF', 'prestacao_contas');
        $this->insertRoute('prestacao_contas_stn_amf', 'STN :: AMF', 'prestacao_contas');
        $this->insertRoute('prestacao_contas_stn_arf', 'STN :: ARF', 'prestacao_contas');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
