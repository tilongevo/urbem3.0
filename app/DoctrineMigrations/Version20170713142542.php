<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170713142542 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_patrimonial_licitacao_documentos_create', 'urbem_patrimonial_licitacao_documentos_list');
        $this->removeRoute('urbem_patrimonial_licitacao_documentos_edit', 'urbem_patrimonial_licitacao_documentos_list');
        $this->removeRoute('urbem_patrimonial_licitacao_documentos_delete', 'urbem_patrimonial_licitacao_documentos_list');
        $this->removeRoute('urbem_patrimonial_licitacao_documentos_show', 'urbem_patrimonial_licitacao_documentos_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
