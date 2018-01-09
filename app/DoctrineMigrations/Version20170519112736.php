<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170519112736 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('tributario_divida_ativa_modalidade_home', 'Divida Ativa - Modalidade', 'tributario');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_inscricao_divida_list', 'Inscrição de Dívida', 'tributario_divida_ativa_modalidade_home');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_inscricao_divida_create', 'Incluir', 'urbem_tributario_divida_ativa_modalidade_inscricao_divida_list');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_inscricao_divida_edit', 'Alterar', 'urbem_tributario_divida_ativa_modalidade_inscricao_divida_list');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_inscricao_divida_delete', 'Excluir', 'urbem_tributario_divida_ativa_modalidade_inscricao_divida_list');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_inscricao_divida_show', 'Detalhe', 'urbem_tributario_divida_ativa_modalidade_inscricao_divida_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
