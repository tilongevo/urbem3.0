<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170518132911 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->changeColumnToDateTimeMicrosecondType(AtributoCadEconAutonomoValor::class, 'timestamp');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_autonomo_list', 'Autônomo', 'tributario_economico_cadastro_economico_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_autonomo_create', 'Incluir', 'urbem_tributario_economico_cadastro_economico_autonomo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_autonomo_edit', 'Alterar', 'urbem_tributario_economico_cadastro_economico_autonomo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_autonomo_delete', 'Excluir', 'urbem_tributario_economico_cadastro_economico_autonomo_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_autonomo_show', 'Detalhe', 'urbem_tributario_economico_cadastro_economico_autonomo_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
