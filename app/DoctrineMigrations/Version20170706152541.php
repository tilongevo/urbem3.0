<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170706152541 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('prestacao_contas_tce_create');
        $this->insertRoute('prestacao_contas_relatorio_tce_list', 'Relatório', 'prestacao_contas_tce_dinamico');
        $this->insertRoute('prestacao_contas_relatorio_tce_create', 'Novo', 'prestacao_contas_relatorio_tce_list');
        $this->insertRoute('prestacao_contas_relatorio_tce_show', 'Detalhes', 'prestacao_contas_relatorio_tce_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
