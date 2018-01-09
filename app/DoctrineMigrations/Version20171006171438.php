<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171006171438 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_ferias_list', 'Consultar Registro Evento de Férias', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_ferias_detalhe', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_ferias_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_ferias_list', 'Consultar Registro Evento de Férias', 'folha_pagamento_folhas_index');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_pagamento_consulta_registro_evento_ferias_detalhe', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_ferias_list');
    }
}
