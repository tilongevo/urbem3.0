<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170707149945 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(LicencaBaixa::class, 'timestamp');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_licenca_baixa_create', 'Baixar Licença', 'urbem_tributario_imobiliario_licencas_licenca_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
