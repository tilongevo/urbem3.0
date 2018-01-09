<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170531185817 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_list', 'Registrar Evento de Férias por Contrato', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_show', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_ferias_create', 'Evento - Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_ferias_delete', 'Evento - Apagar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_list', 'Registrar Evento de Férias por Contrato', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_show', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_ferias_create', 'Evento - Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_ferias_delete', 'Evento - Apagar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_ferias_list');
    }
}
