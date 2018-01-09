<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170622165528 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_list', 'Folha Salário - Consulta Registros Eventos', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_batch', 'Folha Salário - Consulta Registros Eventos', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_show', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_list', 'Folha Salário - Consulta Registros Eventos', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_batch', 'Folha Salário - Consulta Registros Eventos', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_show', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_list');
    }
}
