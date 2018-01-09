<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170609202238 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->updateUpperRoute('urbem_recursos_humanos_pessoal_caso_causa_create', 'urbem_recursos_humanos_pessoal_causa_rescisao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_pessoal_caso_causa_edit', 'urbem_recursos_humanos_pessoal_causa_rescisao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_pessoal_caso_causa_delete', 'urbem_recursos_humanos_pessoal_causa_rescisao_list');
        $this->removeRoute('urbem_recursos_humanos_pessoal_caso_causa_show', 'urbem_recursos_humanos_pessoal_caso_causa_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
