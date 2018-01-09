<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170419141308 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->removeRoute('urbem_patrimonial_compras_solicitacao_item_create', 'urbem_patrimonial_compras_solicitacao_list');
        $this->removeRoute('urbem_patrimonial_compras_solicitacao_item_edit', 'urbem_patrimonial_compras_solicitacao_list');
        $this->removeRoute('urbem_patrimonial_compras_solicitacao_item_delete', 'urbem_patrimonial_compras_solicitacao_list');
        $this->removeRoute('urbem_patrimonial_compras_solicitacao_item_show', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_create', 'Itens - Novo', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_edit', 'Itens - Editar', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_delete', 'Itens - Apagar', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_show', 'Itens - Detalhes', 'urbem_patrimonial_compras_solicitacao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
