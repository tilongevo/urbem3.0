<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170822200318 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_ima_exportar_remessa_bb_create', 'Exportar Pagamentos - Banco do Brasil', 'informacoes_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_ima_exportar_remessa_bb_detalhe', 'Detalhes', 'urbem_recursos_humanos_ima_exportar_remessa_bb_create');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_ima_exportar_remessa_bb_create', 'Exportar Pagamentos - Banco do Brasil', 'informacoes_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_ima_exportar_remessa_bb_detalhe', 'Detalhes', 'urbem_recursos_humanos_ima_exportar_remessa_bb_create');
    }
}
