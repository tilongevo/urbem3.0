<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170605201349 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_complementar_list', 'Folha Complementar - Calcular Folha Complementar', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_complementar_batch', 'Folha Complementar - Calcular Folha Complementar', 'folha_pagamento_folhas_index');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_complementar_list', 'Folha Complementar - Calcular Folha Complementar', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_complementar_batch', 'Folha Complementar - Calcular Folha Complementar', 'folha_pagamento_folhas_index');
    }
}
