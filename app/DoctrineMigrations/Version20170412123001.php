<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170412123001 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_create', 'Aditivo - Novo', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_edit', 'Aditivo - Editar', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_delete', 'Aditivo - Apagar', 'urbem_patrimonial_licitacao_convenio_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
