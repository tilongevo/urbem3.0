<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170901143648 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_divida_ativa_relatorio_pagadores_grupo_credito', 'Grupo de Crédito', 'tributario_divida_ativa_relatorio_pagadores_filtro');
        $this->insertRoute('urbem_tributario_divida_ativa_relatorio_pagadores_credito', 'Crédito', 'tributario_divida_ativa_relatorio_pagadores_filtro');
        $this->insertRoute('tributario_divida_ativa_relatorio_pagadores_filtro', 'Relatório de Pagadores', 'tributario_divida_ativa_relatorios_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
