<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171216121645 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("ALTER TABLE almoxarifado.requisicao ADD COLUMN cod_requisicao_pai INT");

        $this->changeColumnToDateTimeMicrosecondType(RequisicaoHomologada::class, 'timestamp');

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_compras_governamentais_requisicao_homologar', 'Homologar', 'urbem_compras_governamentais_requisicao_list');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_compras_governamentais_requisicao_anular', 'Anular', 'urbem_compras_governamentais_requisicao_list');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_compras_governamentais_requisicao_anular_homologacao', 'Anular Homologação', 'urbem_compras_governamentais_requisicao_list');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_compras_governamentais_controle_itens_list', 'Controle de Itens', 'compras_governamentais');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_compras_governamentais_controle_itens_autorizar_requisicao', 'Autorizar Requisição', 'urbem_compras_governamentais_controle_itens_list');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_compras_governamentais_controle_itens_autorizar_requisicao', 'Autorizar Requisição', 'urbem_compras_governamentais_controle_itens_list');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_compras_governamentais_controle_itens_autorizar_solicitacao_compra', 'Autorizar Solicitação de Compra', 'urbem_compras_governamentais_controle_itens_list');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_compras_governamentais_controle_itens_recusar_requisicao', 'Recusar Rquisição', 'urbem_compras_governamentais_controle_itens_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("ALTER TABLE almoxarifado.requisicao DROP COLUMN cod_requisicao_pai");
    }
}
