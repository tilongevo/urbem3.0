<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170411144638 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_list', 'Cálculo de Benefícios', 'folha_pagamento_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_create', 'Criar', 'urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
