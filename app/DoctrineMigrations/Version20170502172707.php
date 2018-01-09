<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170502172707 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list', 'Configuração Contracheque', 'folha_pagamento_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_create', 'Novo', 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_delete', 'Remover', 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_show', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');
        $this->createSequence('folhapagamento.cod_configuracao_contra_seq', 'folhapagamento', 'configuracao_contracheque', 'cod_configuracao_contra');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_create');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_edit');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_delete');
        $this->removeRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_show');
        $this->dropSequence('folhapagamento.cod_configuracao_contra_seq', 'folhapagamento', 'configuracao_contracheque', 'cod_configuracao_contra');
    }
}
