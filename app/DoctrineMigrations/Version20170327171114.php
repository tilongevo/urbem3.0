<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170327171114 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_patrimonial_compras_fornecedor_socio_delete', 'Apagar Sócio', 'urbem_patrimonial_compras_fornecedor_list');
        $this->insertRoute('urbem_patrimonial_compras_fornecedor_conta_delete', 'Apagar Conta', 'urbem_patrimonial_compras_fornecedor_list');
        $this->insertRoute('urbem_patrimonial_compras_fornecedor_classificacao_delete', 'Apagar Classificação', 'urbem_patrimonial_compras_fornecedor_list');
        $this->updateUpperRoute('urbem_patrimonial_compras_fornecedor_socio_create', 'urbem_patrimonial_compras_fornecedor_list');
        $this->updateUpperRoute('urbem_patrimonial_compras_fornecedor_conta_create', 'urbem_patrimonial_compras_fornecedor_list');
        $this->updateUpperRoute('urbem_patrimonial_compras_fornecedor_classificacao_create', 'urbem_patrimonial_compras_fornecedor_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
