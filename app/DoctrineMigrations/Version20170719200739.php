<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170719200739 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_recursos_humanos_informacoes_configuracao_besc_list');
        $this->removeRoute('urbem_recursos_humanos_informacoes_configuracao_besc_create');
        $this->removeRoute('urbem_recursos_humanos_informacoes_configuracao_besc_edit');
        $this->removeRoute('urbem_recursos_humanos_informacoes_configuracao_besc_remove');
        $this->insertRoute('urbem_recursos_humanos_informacoes_configuracao_besc_list', 'Besc', 'informacoes_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_informacoes_configuracao_besc_create', 'Exportação', 'urbem_recursos_humanos_informacoes_configuracao_besc_list');
        $this->insertRoute('urbem_recursos_humanos_informacoes_configuracao_besc_edit', 'Editar', 'urbem_recursos_humanos_informacoes_configuracao_besc_list');
        $this->insertRoute('urbem_recursos_humanos_informacoes_configuracao_besc_remove', 'Remover', 'urbem_recursos_humanos_informacoes_configuracao_besc_list');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
