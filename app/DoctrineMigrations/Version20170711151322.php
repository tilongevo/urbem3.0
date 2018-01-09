<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170711151322 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(AtributoTipoLicencaImovelValor::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoTipoLicencaLoteValor::class, 'timestamp');

        $this->insertRoute('urbem_tributario_imobiliario_licencas_licenca_cassacao_create', 'Cassar Licença', 'urbem_tributario_imobiliario_licencas_licenca_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
