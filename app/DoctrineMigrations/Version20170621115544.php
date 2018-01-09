<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170621115544 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('arrecadacao.tipo_pagamento_cod_seq', 'arrecadacao', 'tipo_pagamento', 'cod_tipo');

        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_arrecadacao_tipo_baixa_list', 'Arrecadação - Tipo de Baixa', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_arrecadacao_tipo_baixa_create', 'Incluir Tipo de Baixa', 'urbem_tributario_arrecadacao_tipo_baixa_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_arrecadacao_tipo_baixa_edit', 'Editar Tipo de Baixa', 'urbem_tributario_arrecadacao_tipo_baixa_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_arrecadacao_tipo_baixa_delete', 'Excluir  Tipo de Baixa', 'urbem_tributario_arrecadacao_tipo_baixa_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_arrecadacao_tipo_baixa_show', 'Detalhe Tipo de Baixa', 'urbem_tributario_arrecadacao_tipo_baixa_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
