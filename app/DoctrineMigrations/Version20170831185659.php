<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170831185659 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_divida_ativa_relatorio_devedores_grupo_credito', 'Grupo de Crédito', 'tributario_divida_ativa_relatorio_devedores_filtro');
        $this->insertRoute('urbem_tributario_divida_ativa_relatorio_devedores_credito', 'Crédito', 'tributario_divida_ativa_relatorio_devedores_filtro');
        $this->insertRoute('tributario_divida_ativa_relatorio_devedores_filtro', 'Relatório de Devedores', 'tributario_divida_ativa_relatorios_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
