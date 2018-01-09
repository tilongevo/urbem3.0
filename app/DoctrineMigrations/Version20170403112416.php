<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170403112416 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_fgts_list', 'Folha de Pagamento - FGTS', 'recursos_humanos');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_fgts_create', 'Novo', 'urbem_recursos_humanos_folha_pagamento_fgts_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_fgts_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_fgts_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_fgts_show', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_fgts_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_fgts_delete', 'Apagar', 'urbem_recursos_humanos_folha_pagamento_fgts_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
