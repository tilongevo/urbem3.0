<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170504143843 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence("folhapagamento.cod_evento_seq", "folhapagamento", "evento", "cod_evento");
        $this->insertRoute("urbem_recursos_humanos_folha_pagamento_evento_list", "Folha de Pagamento - Evento", "recursos_humanos");
        $this->insertRoute("urbem_recursos_humanos_folha_pagamento_evento_create", "Novo", "urbem_recursos_humanos_folha_pagamento_evento_list");
        $this->insertRoute("urbem_recursos_humanos_folha_pagamento_evento_edit", "Editar", "urbem_recursos_humanos_folha_pagamento_evento_list");
        $this->insertRoute("urbem_recursos_humanos_folha_pagamento_evento_show", "Detalhes", "urbem_recursos_humanos_folha_pagamento_evento_list");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->dropSequence("folhapagamento.cod_evento_seq", "folhapagamento", "evento", "cod_evento");
        $this->removeRoute("urbem_recursos_humanos_folha_pagamento_evento_list");
        $this->removeRoute("urbem_recursos_humanos_folha_pagamento_evento_create");
        $this->removeRoute("urbem_recursos_humanos_folha_pagamento_evento_edit");
        $this->removeRoute("urbem_recursos_humanos_folha_pagamento_evento_show");
    }
}
