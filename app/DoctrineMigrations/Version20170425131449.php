<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170425131449 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute("urbem_recursos_humanos_folha_pagamento_configurar_ferias_create", "Configurar Férias", "folha_pagamento_configuracao_home");
        $this->insertRoute("urbem_recursos_humanos_folha_pagamento_configurar_ferias_edit", "Configurar Férias", "folha_pagamento_configuracao_home");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute("urbem_recursos_humanos_folha_pagamento_configurar_ferias_create");
        $this->removeRoute("urbem_recursos_humanos_folha_pagamento_configurar_ferias_edit");
    }
}
