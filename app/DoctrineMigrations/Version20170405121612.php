<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170405121612 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('patrimonio_manutencao_home', 'Manutenção', 'patrimonial');
        $this->removeRoute('urbem_patrimonial_patrimonio_manutencao_list');
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_list', 'Agendar', 'patrimonio_manutencao_home');
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_create', 'Agendamento - Novo', 'urbem_patrimonial_patrimonio_manutencao_list');
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_edit', 'Agendamento - Editar', 'urbem_patrimonial_patrimonio_manutencao_list');
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_paga_list', 'Inserir Manutenção', 'patrimonio_manutencao_home');
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_paga_create', 'Novo', 'urbem_patrimonial_patrimonio_manutencao_paga_list');
        $this->insertRoute('urbem_patrimonial_patrimonio_excluir_manutencao_paga_list', 'Excluir Manutenção', 'patrimonio_manutencao_home');
        $this->insertRoute('urbem_patrimonial_patrimonio_excluir_manutencao_paga_delete', 'Apagar', 'urbem_patrimonial_patrimonio_excluir_manutencao_paga_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
