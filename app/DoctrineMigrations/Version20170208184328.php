<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170208184328 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DELETE FROM administracao.rota WHERE descricao_rota IN (
            'urbem_patrimonial_frota_veiculo_locacao_delete'
            ,'urbem_patrimonial_frota_veiculo_locacao_create'
            ,'urbem_patrimonial_frota_veiculo_locacao_show'
            ,'urbem_patrimonial_frota_veiculo_locacao_edit'
            ,'urbem_patrimonial_frota_veiculo_locacao_list'
            ,'urbem_patrimonial_frota_veiculo_cessao_create'
            ,'urbem_patrimonial_frota_veiculo_cessao_list'
            ,'urbem_patrimonial_frota_veiculo_cessao_edit'
            ,'urbem_patrimonial_frota_veiculo_cessao_show'
            , 'urbem_patrimonial_frota_veiculo_cessao_delete'
            ,'urbem_patrimonial_frota_veiculo_documento_delete'
            ,'urbem_patrimonial_frota_veiculo_documento_create'
            ,'urbem_patrimonial_frota_veiculo_documento_edit'
            ,'urbem_patrimonial_frota_veiculo_documento_list'
            ,'urbem_patrimonial_frota_veiculo_documento_show'
            ,'urbem_patrimonial_frota_veiculo_proprio_list'
            ,'urbem_patrimonial_frota_veiculo_proprio_create'
            ,'urbem_patrimonial_frota_veiculo_proprio_edit'
            ,'urbem_patrimonial_frota_veiculo_proprio_delete'
            ,'urbem_patrimonial_frota_veiculo_proprio_show'
            ,'urbem_patrimonial_frota_veiculo_terceiro_list'
            ,'urbem_patrimonial_frota_veiculo_terceiro_edit'
            ,'urbem_patrimonial_frota_veiculo_terceiro_create'
            ,'urbem_patrimonial_frota_veiculo_terceiro_delete'
            ,'urbem_patrimonial_frota_veiculo_terceiro_show'
            ,'urbem_patrimonial_frota_excluir_baixa_veiculo_list'
            ,'urbem_patrimonial_frota_excluir_baixa_veiculo_create'
        );");
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_locacao_create\', \'Terceiro - Locação - Novo\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_locacao_edit\', \'Terceiro - Locação - Editar\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_locacao_delete\', \'Terceiro - Locação - Remover\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_locacao_show\', \'Terceiro - Locação - Detalhes\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_terceiro_create\', \'Terceiro - Novo\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_terceiro_edit\', \'Terceiro - Editar\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_terceiro_delete\', \'Terceiro - Remover\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_terceiro_show\', \'Terceiro - Detalhes\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_cessao_create\', \'Cessão - Novo\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_cessao_edit\', \'Cessão - Editar\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_cessao_delete\', \'Cessão -Remover\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_cessao_show\', \'Cessão -Detalhes\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_documento_create\', \'Controle de Documentos - Novo\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_documento_edit\', \'Controle de Documentos - Editar\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_documento_delete\', \'Controle de Documentos - Remover\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_patrimonial_frota_veiculo_documento_show\', \'Controle de Documentos Detalhes\', \'urbem_patrimonial_frota_veiculo_list\');');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_patrimonial_frota_veiculo_proprio_list', 'Próprio', 'urbem_patrimonial_frota_veiculo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_patrimonial_frota_veiculo_proprio_create', 'Próprio - Novo', 'urbem_patrimonial_frota_veiculo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_patrimonial_frota_veiculo_proprio_edit', 'Próprio -  Editar', 'urbem_patrimonial_frota_veiculo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_patrimonial_frota_veiculo_proprio_delete', 'Próprio - Remover', 'urbem_patrimonial_frota_veiculo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_patrimonial_frota_veiculo_proprio_show', 'Próprio - Detalhes', 'urbem_patrimonial_frota_veiculo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_patrimonial_frota_excluir_baixa_veiculo_list', ' Baixa de Veículo', 'urbem_patrimonial_frota_veiculo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_patrimonial_frota_excluir_baixa_veiculo_create', ' Baixa de Veículo', 'urbem_patrimonial_frota_veiculo_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
