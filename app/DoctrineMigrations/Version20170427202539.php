<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170427202539 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute("urbem_recursos_humanos_folha_pagamento_configuracao_create", "Alterar Configuração", "folha_pagamento_configuracao_home");
        $this->insertRoute("urbem_recursos_humanos_folha_pagamento_configuracao_edit", "Alterar Configuração", "folha_pagamento_configuracao_home");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute("urbem_recursos_humanos_folha_pagamento_configuracao_create");
        $this->removeRoute("urbem_recursos_humanos_folha_pagamento_configuracao_edit");
    }
}
