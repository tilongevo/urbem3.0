<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170516144823 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_create', 'Mapa de Compras - Solicitação - Novo', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_edit', 'Mapa de Compras - Solicitação - Editar', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_delete', 'Mapa de Compras - Solicitação - Apagar', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_show', 'Mapa de Compras - Solicitação - Detalhes', 'urbem_patrimonial_compras_mapa_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
