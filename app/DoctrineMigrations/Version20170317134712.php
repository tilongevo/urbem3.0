<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170317134712 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->updateUpperRoute('urbem_financeiro_orcamento_unidade_create', 'financeiro_orcamento_unidade_filtro');
        $this->updateUpperRoute('urbem_financeiro_orcamento_unidade_edit', 'financeiro_orcamento_unidade_filtro');
        $this->updateUpperRoute('urbem_financeiro_orcamento_unidade_delete', 'financeiro_orcamento_unidade_filtro');
        $this->updateUpperRoute('urbem_financeiro_orcamento_unidade_show', 'financeiro_orcamento_unidade_filtro');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
