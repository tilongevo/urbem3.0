<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170512203156 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list', 'Folha Salário', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_create', 'Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_show', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_delete', 'Apagar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_create', 'Evento - Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_delete', 'Evento - Apagar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list');
    }

    /**
     * @param Schema $schemaDetalhes
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
