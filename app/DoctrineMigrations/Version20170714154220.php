<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170714154220 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_caixa_list', 'Caixa', 'informacoes_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_caixa_create', 'Exportação', 'urbem_recursos_humanos_ima_configuracao_caixa_list');
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_caixa_edit', 'Editar', 'urbem_recursos_humanos_ima_configuracao_caixa_list');
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_caixa_remove', 'Remover', 'urbem_recursurbem_recursos_humanos_ima_configuracao_caixa_listos_humanos_ima_configuracao_bradesco_list');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
