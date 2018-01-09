<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170920174530 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("update administracao.rota set descricao_rota = 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_decimo_list', traducao_rota = 'Folha 13º Salário - Conceder 13º Salário', rota_superior = 'folha_pagamento_folhas_index' where descricao_rota = 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_list';");
        $this->addSql("update administracao.rota set descricao_rota = 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_decimo_batch', traducao_rota = 'Folha 13º Salário - Conceder 13º Salário', rota_superior = 'folha_pagamento_folhas_index' where descricao_rota = 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_batch';");
        $this->addSql("update administracao.rota set descricao_rota = 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_decimo_show', traducao_rota = 'Detalhe', rota_superior = 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_decimo_list' where descricao_rota = 'urbem_recursos_humanos_folha_pagamento_folhas_conceder_cancelar_decimo_show';");
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_cancelar_decimo_list', 'Folha 13º Salário - Cancelar 13º Salário', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_cancelar_decimo_batch', 'Folha 13º Salário - Cancelar 13º Salário', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_cancelar_decimo_show', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_folhas_cancelar_decimo_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
