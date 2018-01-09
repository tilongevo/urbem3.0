<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170710174910 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_licenca_suspensao_create', 'Suspender Licença', 'urbem_tributario_imobiliario_licencas_licenca_list');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_licenca_cancelar_suspensao_create', 'Cancelar Suspensão da Licença', 'urbem_tributario_imobiliario_licencas_licenca_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
