<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Imobiliario\Licenca;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170630135903 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Licenca::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LicencaDocumento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(EmissaoDocumento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LicencaResponsavelTecnico::class, 'timestamp');

        $this->insertRoute('urbem_tributario_imobiliario_licencas_licenca_list', 'Conceder Licença', 'tributario_imobiliario_licencas_home');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_licenca_create', 'Incluir Licença', 'urbem_tributario_imobiliario_licencas_licenca_list');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_licenca_edit', 'Alterar Licença', 'urbem_tributario_imobiliario_licencas_licenca_list');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_licenca_delete', 'Excluir Licença', 'urbem_tributario_imobiliario_licencas_licenca_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
