<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170519122113 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('arrecadacao.cod_desoneracao_seq', 'arrecadacao', 'desoneracao', 'cod_desoneracao');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'tributario_arrecadacao_desoneracao_home', 'Arrecadação - Desoneração', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list', 'Definir Desoneração', 'tributario_arrecadacao_desoneracao_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_create', 'Incluir', 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_edit', 'Alterar', 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_delete', 'Excluir', 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_show', 'Detalhe', 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
