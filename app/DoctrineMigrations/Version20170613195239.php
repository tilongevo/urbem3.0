<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170613195239 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_list', 'Folha 13º Salário - Conceder/Cancelar 13º Salário', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_batch', 'Folha 13º Salário - Conceder/Cancelar 13º Salário', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_show', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_list', 'Folha 13º Salário - Conceder/Cancelar 13º Salário', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_batch', 'Folha 13º Salário - Conceder/Cancelar 13º Salário', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_show', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_list');
    }
}
