<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170508143418 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_tributario_imobiliario_lote_list');

        $this->insertRoute('tributario_imobiliario_lote_home', 'Cadastro Imobiliário - Lote', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_lote_list', 'Lote Urbano/Rural', 'tributario_imobiliario_lote_home');

        $this->insertRoute('urbem_tributario_imobiliario_cancelar_desmembramento_list', 'Desmembramento', 'tributario_imobiliario_lote_home');
        $this->insertRoute('urbem_tributario_imobiliario_cancelar_desmembramento_delete', 'Cancelar', 'urbem_tributario_imobiliario_cancelar_desmembramento_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
