<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161128142001 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("SELECT public.adiciona_coluna('administracao', 'atributo_dinamico', 'cod_atributo_anterior', 'integer');");
        $this->addSql("SELECT public.adiciona_coluna('almoxarifado', 'catalogo_item', 'cod_item_externo', 'varchar');");
        $this->addSql("SELECT public.adiciona_coluna('almoxarifado', 'catalogo_item', 'material', 'integer');");
        $this->addSql("SELECT public.adiciona_coluna('almoxarifado', 'catalogo_item', 'classe', 'integer');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
