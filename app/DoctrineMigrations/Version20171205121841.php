<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171205121841 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_list', 'Despesas', 'financeiro_orcamento_elaboracao_orcamento_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_create', 'Incluir Despesa', 'financeiro_orcamento_elaboracao_orcamento_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_edit', 'Alterar Despesa', 'financeiro_orcamento_elaboracao_orcamento_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_delete', 'Excluir Despesa', 'financeiro_orcamento_elaboracao_orcamento_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_acao_list', 'Lista de Ações - Despesas', 'financeiro_orcamento_elaboracao_orcamento_home');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        
        $this->addSql('DELETE FROM administracao.rota WHERE descricao_rota = \'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_list\';');
        $this->addSql('DELETE FROM administracao.rota WHERE descricao_rota = \'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_create\';');
        $this->addSql('DELETE FROM administracao.rota WHERE descricao_rota = \'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_edit\';');
        $this->addSql('DELETE FROM administracao.rota WHERE descricao_rota = \'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_delete\';');
        $this->addSql('DELETE FROM administracao.rota WHERE descricao_rota = \'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_acao_list\';');
    }
}
