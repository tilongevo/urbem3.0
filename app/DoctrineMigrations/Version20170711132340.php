<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170711132340 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_patrimonial_compras_solicitacoes_itens_edit');
        $this->removeRoute('urbem_patrimonial_compras_solicitacoes_itens_delete');
        $this->removeRoute('urbem_patrimonial_compras_solicitacoes_itens_edit');
        $this->removeRoute('urbem_patrimonial_compras_solicitacoes_itens_delete');
        $this->removeRoute('urbem_patrimonial_compras_solicitacoes_itens_create');

        $this->insertRoute('urbem_patrimonial_compras_solicitacoes_itens_incluir', 'Incluir Itens de Outras Solicitações', 'urbem_patrimonial_compras_solicitacao_show');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('UPDATE administracao.rota SET traducao_rota = ?, descricao_rota = ? WHERE descricao_rota = ? AND rota_superior = ?', [
            'Itens de Outras Solicitações - Novo',
            'urbem_patrimonial_compras_solicitacoes_itens_create',
            'urbem_patrimonial_compras_solicitacoes_itens_incluir',
            'urbem_patrimonial_compras_solicitacao_list'
        ]);
    }
}
