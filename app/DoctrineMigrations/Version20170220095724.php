<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para criar amarração entre as entidades Almoxarifado.CatalogoItem e
 * Almoxarifado.AtributoCatalogoClassificacaoItemValor
 */
class Version20170220095724 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE almoxarifado.atributo_catalogo_classificacao_item_valor DROP CONSTRAINT IF EXISTS fk_catalogoItem_atributoCatalogoClassificacaoItemValor');
        $this->addSql('ALTER TABLE almoxarifado.atributo_catalogo_classificacao_item_valor ADD CONSTRAINT fk_catalogoItem_atributoCatalogoClassificacaoItemValor FOREIGN KEY (cod_item)
            REFERENCES almoxarifado.catalogo_item (cod_item) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('DROP INDEX IF EXISTS almoxarifado.idx_catalogoItem_atributoCatalogoClassificacaoItemValor');
        $this->addSql('CREATE INDEX idx_catalogoItem_atributoCatalogoClassificacaoItemValor ON almoxarifado.atributo_catalogo_classificacao_item_valor (cod_item)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE almoxarifado.atributo_catalogo_classificacao_item_valor DROP CONSTRAINT IF EXISTS fk_catalogoItem_atributoCatalogoClassificacaoItemValor');
        $this->addSql('DROP INDEX IF EXISTS almoxarifado.idx_catalogoItem_atributoCatalogoClassificacaoItemValor');
    }
}
