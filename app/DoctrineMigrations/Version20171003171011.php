<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171003171011 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_decimo_list', 'Folha Décimo - Consultar Ficha Financeira', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_decimo_show', 'Folha Décimo - Detalhes Ficha Financeira', 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_decimo_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_ferias_list', 'Folha Férias - Consultar Ficha Financeira', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_ferias_show', 'Folha Férias - Detalhes Ficha Financeira', 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_ferias_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_salario_list', 'Folha Salário - Consultar Ficha Financeira', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_salario_show', 'Folha Salário - Detalhes Ficha Financeira', 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_salario_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_rescisao_list', 'Folha Rescisão - Consultar Ficha Financeira', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_rescisao_show', 'Folha Rescisão - Detalhes Ficha Financeira', 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_rescisao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_decimo_list', 'folha_pagamento_folhas_index');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_decimo_show', 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_decimo_list');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_ferias_list', 'folha_pagamento_folhas_index');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_ferias_show', 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_ferias_list');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_salario_list', 'folha_pagamento_folhas_index');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_salario_show', 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_salario_list');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_rescisao_list', 'folha_pagamento_folhas_index');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_rescisao_show', 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_rescisao_list');
    }
}
