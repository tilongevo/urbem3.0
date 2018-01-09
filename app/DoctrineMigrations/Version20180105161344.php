<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180105161344 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_patrimonial_frota_relatorios_veiculo_create', 'Relatório de Veículo', 'patrimonio_frota_relatorios_home');
        $this->addSql("DELETE FROM administracao.rota WHERE traducao_rota = 'Patrimonial - Configuração';");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Patrimonial - Relatórios' WHERE descricao_rota = 'patrimonio_frota_relatorios_home';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
