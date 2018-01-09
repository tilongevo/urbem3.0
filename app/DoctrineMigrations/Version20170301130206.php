<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170301130206 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute("urbem_patrimonial_compras_compra_direta_list");
        $this->insertRoute(
            "urbem_patrimonial_compras_compra_direta_list",
            "Compras - Compra Direta",
            "patrimonio_compras_compra_direta_home"
        );
        $this->removeRoute("patrimonio_compras_compra_direta_home");
        $this->insertRoute(
            "patrimonio_compras_compra_direta_home",
            "Compra Direta",
            "patrimonial"
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
