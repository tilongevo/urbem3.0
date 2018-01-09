<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171122115229 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("ALTER TABLE almoxarifado.catalogo_item ADD COLUMN prioridade TEXT");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item ADD COLUMN divisivel BOOLEAN NOT NULL DEFAULT false");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item ADD COLUMN cod_unidade_compra INTEGER");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item ADD COLUMN cod_grandeza_compra INTEGER");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item ADD COLUMN desmembravel BOOLEAN NOT NULL DEFAULT false");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item ADD COLUMN descricao_completa_nome_arquivo TEXT");

        $this->addSql("ALTER TABLE almoxarifado.controle_estoque ADD COLUMN estoque_minimo_compra NUMERIC(14,4) NOT NULL DEFAULT 0");
        $this->addSql("ALTER TABLE almoxarifado.controle_estoque ADD COLUMN estoque_maximo_compra NUMERIC(14,4) NOT NULL DEFAULT 0");
        $this->addSql("ALTER TABLE almoxarifado.controle_estoque ADD COLUMN ponto_pedido_compra NUMERIC(14,4) NOT NULL DEFAULT 0");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("ALTER TABLE almoxarifado.catalogo_item DROP COLUMN prioridade");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item DROP COLUMN divisivel");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item DROP COLUMN cod_unidade_compra");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item DROP COLUMN cod_grandeza_compra");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item DROP COLUMN desmembravel");
        $this->addSql("ALTER TABLE almoxarifado.catalogo_item DROP COLUMN descricao_completa_nome_arquivo");

        $this->addSql("ALTER TABLE almoxarifado.controle_estoque DROP COLUMN estoque_minimo_compra");
        $this->addSql("ALTER TABLE almoxarifado.controle_estoque DROP COLUMN estoque_maximo_compra");
        $this->addSql("ALTER TABLE almoxarifado.controle_estoque DROP COLUMN ponto_pedido_compra");
    }
}
