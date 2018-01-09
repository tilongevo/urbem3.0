<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170712132617 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_matricula_create', 'Folha Salário - Registrar Lote Eventos/Matrículas', 'folha_pagamento_folhas_index');
        $this->addSql("SELECT setval(
        'folhapagamento.registro_evento_periodo_seq',
        COALESCE((SELECT MAX(cod_registro) + 1
                          FROM folhapagamento.registro_evento_periodo), 1),
                FALSE
            );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_matricula_create', 'Folha Salário - Registrar Lote Eventos/Matrículas', 'folha_pagamento_folhas_index');
    }
}
