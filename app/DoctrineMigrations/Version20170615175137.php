<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170615175137 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DELETE FROM administracao.rota WHERE descricao_rota LIKE \'urbem_tributario_monetario_acrescimo_%\';');

        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_acrescimo_list', 'Cadastro Monetário - Acréscimo', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_acrescimo_create', 'Incluir', 'urbem_tributario_monetario_acrescimo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_acrescimo_edit', 'Alterar', 'urbem_tributario_monetario_acrescimo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_acrescimo_delete', 'Excluir', 'urbem_tributario_monetario_acrescimo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_acrescimo_show', 'Detalhe', 'urbem_tributario_monetario_acrescimo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_acrescimo_formula_calculo', 'Alterar Fórmula de Cálculo', 'urbem_tributario_monetario_acrescimo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_acrescimo_definir_valor', 'Definir Valor', 'urbem_tributario_monetario_acrescimo_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
