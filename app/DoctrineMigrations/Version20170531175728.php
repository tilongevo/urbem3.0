<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170531175728 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_comprovante_rendimento_create', 'Comprovante de Rendimentos - Novo', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_comprovante_rendimento_delete', 'Comprovante de Rendimentos - Remover', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_tabela_irrf_comprovante_rendimento_edit', 'Comprovante de Rendimentos - Editar', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');

        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_faixa_desconto_irrf_create', 'Faixas de Descontos Cadastradas - Novo', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_faixa_desconto_irrf_delete', 'Faixas de Descontos Cadastradas - Remover', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_faixa_desconto_irrf_edit', 'Faixas de Descontos Cadastradas - Editar', 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
