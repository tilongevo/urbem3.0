<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170728124832 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_relatorios_customizavel_eventos_create', 'Customizável de Eventos', 'folha_pagamento_relatorios_index');
        $this->addSql('update administracao.rota set traducao_rota = \'Relatórios Folha Pagamento\' where descricao_rota = \'folha_pagamento_relatorios_index\';');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_relatorios_customizavel_eventos_create', 'Customizável de Eventos', 'folha_pagamento_relatorios_index');
        $this->addSql('update administracao.rota set traducao_rota = \'Relatórios Folha Pagamento\' where descricao_rota = \'folha_pagamento_relatorios_index\';');
    }
}
