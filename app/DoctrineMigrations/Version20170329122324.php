<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170329122324 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_patrimonial_compras_solicitacoes_itens_create', 'Itens de Outras Solicitações - Novo', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacoes_itens_edit', 'Itens de Outras Solicitações - Editar', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacoes_itens_delete', 'Itens de Outras Solicitações - Apagar', 'urbem_patrimonial_compras_solicitacao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
