<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170329120725 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_financeiro_tesouraria_configuracao_implantar_saldo_inicial_list');
        $this->removeRoute('urbem_financeiro_tesouraria_configuracao_implantar_saldo_inicial_create');
        $this->removeRoute('urbem_financeiro_tesouraria_configuracao_implantar_saldo_inicial_edit');
        $this->removeRoute('urbem_financeiro_tesouraria_configuracao_implantar_saldo_inicial_delete');
        $this->removeRoute('urbem_financeiro_tesouraria_configuracao_implantar_saldo_inicial_show');
        $this->insertRoute('urbem_financeiro_tesouraria_configuracao_implantar_saldo_inicial_create', 'Implantar Saldos Iniciais', 'tesouraria_configuracao_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
