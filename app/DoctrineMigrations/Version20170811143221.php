<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170811143221 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_rescisao_detalhes_rescisao', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_rescisao_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_rescisao_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_rescisao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_rescisao_detalhes_rescisao', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_rescisao_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_rescisao_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_rescisao_list');
    }
}
