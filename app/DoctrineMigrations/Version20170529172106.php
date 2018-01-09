<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170529172106 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list', 'Registrar Evento na Complementar por Contrato', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_create', 'Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_show', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_complementar_create', 'Evento - Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_complementar_delete', 'Apagar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list');
        $this->createSequence('folhapagamento.cod_registro_seq', 'folhapagamento', 'registro_evento_complementar', 'cod_registro');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list', 'Registrar Evento na Complementar por Contrato', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_create', 'Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_show', 'Detalhe', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_complementar_create', 'Evento - Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_complementar_delete', 'Apagar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar_list');
        $this->createSequence('folhapagamento.cod_registro_seq', 'folhapagamento', 'registro_evento_complementar', 'cod_registro');
    }
}
