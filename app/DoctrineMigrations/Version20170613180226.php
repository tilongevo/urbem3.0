<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170613180226 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DELETE FROM administracao.rota WHERE descricao_rota LIKE \'urbem_tributario_monetario_especie_%\';');

        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_especie_list', 'Cadastro Monetário - Espécie', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_especie_create', 'Incluir', 'urbem_tributario_monetario_especie_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_especie_edit', 'Alterar', 'urbem_tributario_monetario_especie_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_especie_delete', 'Excluir', 'urbem_tributario_monetario_especie_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_especie_show', 'Detalhe', 'urbem_tributario_monetario_especie_list');");

        $this->addSql('DELETE FROM administracao.rota WHERE descricao_rota LIKE \'urbem_tributario_monetario_moeda_%\';');

        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_moeda_list', 'Cadastro Monetário - Moeda', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_moeda_create', 'Incluir', 'urbem_tributario_monetario_moeda_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_moeda_edit', 'Alterar', 'urbem_tributario_monetario_moeda_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_moeda_delete', 'Excluir', 'urbem_tributario_monetario_moeda_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota,descricao_rota, traducao_rota, rota_superior) VALUES ( nextval('administracao.rota_cod_rota_seq'),'urbem_tributario_monetario_moeda_show', 'Detalhe', 'urbem_tributario_monetario_moeda_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
