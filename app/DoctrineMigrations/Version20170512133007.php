<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170512133007 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_list', 'Tabela de IRRF', 'folha_pagamento_irrf_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_create', 'Novo', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_show', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_delete', 'Remover', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');

        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_cid_list', 'CIDs Isentas de IRRF', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_cid_create', 'CIDs Isentas de IRRF - Novo', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_cid_edit', 'CIDs Isentas de IRRF - Editar', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_cid_show', 'CIDs Isentas de IRRF - Detalhes', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_cid_delete', 'CIDs Isentas de IRRF - Remover', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
