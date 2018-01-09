<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191049 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->insertRoute('urbem_financeiro_tesouraria_recibo_extra_relatorio', 'Recibo Extra - Emitir Nota', 'urbem_financeiro_tesouraria_recibo_extra_list', true);
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_relatorio', 'Ordem de Pagamento - Emitir O.P.', 'urbem_financeiro_empenho_ordem_pagamento_list', true);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
