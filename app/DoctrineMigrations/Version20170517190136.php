<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170517190136 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('patrimonio_inventario_home', 'Inventário', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_patrimonio_inventario_list', 'Inventário', 'patrimonio_inventario_home');
        $this->insertRoute('urbem_patrimonial_patrimonio_exportacao_arquivo_coletora_list', 'Exportar Arquivo Coletora', 'patrimonio_inventario_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
