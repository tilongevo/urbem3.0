<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170531113844 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_consolidacao_list', 'Consolidação', 'tributario_divida_ativa_modalidade_home');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_consolidacao_create', 'Incluir', 'urbem_tributario_divida_ativa_modalidade_consolidacao_list');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_consolidacao_edit', 'Alterar', 'urbem_tributario_divida_ativa_modalidade_consolidacao_list');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_consolidacao_delete', 'Excluir', 'urbem_tributario_divida_ativa_modalidade_consolidacao_list');
        $this->insertRoute('urbem_tributario_divida_ativa_modalidade_consolidacao_show', 'Detalhe', 'urbem_tributario_divida_ativa_modalidade_consolidacao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
