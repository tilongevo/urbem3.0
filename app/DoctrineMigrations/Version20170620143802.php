<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170620143802 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_arrecadacao_movimentacoes_definir_permissao_list', 'Definir Permissão para Avaliação Imobiliária', 'tributario_arrecadacao_movimentacoes_home');
        $this->insertRoute('urbem_tributario_arrecadacao_movimentacoes_definir_permissao_create', 'Incluir Permissão para Avaliação Imobiliária', 'urbem_tributario_arrecadacao_movimentacoes_definir_permissao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_movimentacoes_definir_permissao_delete', 'Excluir Permissão para Avaliação Imobiliária', 'urbem_tributario_arrecadacao_movimentacoes_definir_permissao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
