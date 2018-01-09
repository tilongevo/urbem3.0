<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170801112529 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_exportar_ipers_create', 'IPERS - Exportar Arquivo IPERS', 'informacoes_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_exportar_ipers_detalhe', 'IPERS - Detalhes Arquivo IPERS', 'informacoes_configuracao_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_exportar_ipers_create', 'IPERS - Exportar Arquivo IPERS', 'informacoes_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_exportar_ipers_detalhe', 'IPERS - Detalhes Arquivo IPERS', 'informacoes_configuracao_home');
    }
}
