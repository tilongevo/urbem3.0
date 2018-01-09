<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170706175504 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_estagio_estagiario_list', 'Estagiários', 'recursos_humanos');
        $this->insertRoute('urbem_recursos_humanos_estagio_estagiario_create', 'Incluir', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->insertRoute('urbem_recursos_humanos_estagio_estagiario_edit', 'Editar', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->insertRoute('urbem_recursos_humanos_estagio_estagiario_delete', 'Excluir', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->insertRoute('urbem_recursos_humanos_estagio_estagiario_show', 'Detalhes', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->insertRoute('urbem_recursos_humanos_estagio_estagiario_estagio_create', 'Estágio - Incluir', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->insertRoute('urbem_recursos_humanos_estagio_estagiario_estagio_edit', 'Estágio - Editar', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->insertRoute('urbem_recursos_humanos_estagio_estagiario_estagio_delete', 'Estágio - Excluir', 'urbem_recursos_humanos_estagio_estagiario_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_recursos_humanos_estagio_estagiario_list', 'recursos_humanos');
        $this->removeRoute('urbem_recursos_humanos_estagio_estagiario_create', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->removeRoute('urbem_recursos_humanos_estagio_estagiario_edit', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->removeRoute('urbem_recursos_humanos_estagio_estagiario_delete', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->removeRoute('urbem_recursos_humanos_estagio_estagiario_show', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->removeRoute('urbem_recursos_humanos_estagio_estagiario_estagio_create', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->removeRoute('urbem_recursos_humanos_estagio_estagiario_estagio_edit', 'urbem_recursos_humanos_estagio_estagiario_list');
        $this->removeRoute('urbem_recursos_humanos_estagio_estagiario_estagio_delete', 'urbem_recursos_humanos_estagio_estagiario_list');
    }
}
