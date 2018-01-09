<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170607174856 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_rescisao_show', 'Folha Rescisão - Calcular Rescisão', 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_rescisao_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_salario_show', 'Folha Salário - Calcular Salário', 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_salario_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_ferias_show', 'Folha Férias - Calcular Férias', 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_ferias_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_decimo_show', 'Folha Décimo - Calcular Décimo', 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_decimo_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_rescisao_show', 'Folha Rescisão - Calcular Rescisão', 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_rescisao_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_salario_show', 'Folha Salário - Calcular Salário', 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_salario_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_ferias_show', 'Folha Férias - Calcular Férias', 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_ferias_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_decimo_show', 'Folha Décimo - Calcular Décimo', 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_decimo_list');
    }
}
