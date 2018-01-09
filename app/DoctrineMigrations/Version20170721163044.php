<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170721163044 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_list', 'Pensão Alimentícia', 'recursos_humanos');
        $this->insertRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_show', 'Detalhes', 'urbem_recursos_humanos_pessoal_pensao_alimenticia_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_create', 'Incluir', 'urbem_recursos_humanos_pessoal_pensao_alimenticia_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_edit', 'Editar', 'urbem_recursos_humanos_pessoal_pensao_alimenticia_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_delete', 'Excluir', 'urbem_recursos_humanos_pessoal_pensao_alimenticia_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->removeRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_list', 'recursos_humanos');
        $this->removeRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_show', 'urbem_recursos_humanos_pessoal_pensao_alimenticia_list');
        $this->removeRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_create', 'urbem_recursos_humanos_pessoal_pensao_alimenticia_list');
        $this->removeRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_edit', 'urbem_recursos_humanos_pessoal_pensao_alimenticia_list');
        $this->removeRoute('urbem_recursos_humanos_pessoal_pensao_alimenticia_delete', 'urbem_recursos_humanos_pessoal_pensao_alimenticia_list');
    }
}
