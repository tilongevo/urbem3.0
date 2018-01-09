<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171108120254 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_arrecadacao_baixa_debitos_compensar_pagamento_list', 'Compensar Pagamentos', 'tributario_arrecadacao_baixa_debitos_home');
        $this->insertRoute('urbem_tributario_arrecadacao_baixa_debitos_compensar_pagamento_edit', 'Compensar', 'urbem_tributario_arrecadacao_baixa_debitos_compensar_pagamento_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
