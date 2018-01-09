<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171212192343 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE almoxarifado.catalogo_item ADD COLUMN foto VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE almoxarifado.catalogo_item ADD COLUMN descricao_foto VARCHAR(255) DEFAULT NULL');
        $this->insertRoute('urbem_patrimonial_almoxarifado_catalogo_item_foto_create', 'Incluir Imagem', 'urbem_patrimonial_almoxarifado_catalogo_item_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE almoxarifado.catalogo_item DROP COLUMN IF EXISTS foto;');
        $this->addSql('ALTER TABLE almoxarifado.catalogo_item DROP COLUMN IF EXISTS descricao_foto;');
    }
}
