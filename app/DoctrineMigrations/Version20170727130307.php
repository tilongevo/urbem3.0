<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Class Version20170727130307
 *
 * @package Application\Migrations
 */
class Version20170727130307 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->insertRoute('patrimonio_almoxarifado_relatorios_home', 'Relatórios', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_relatorios_itens_estoque', 'Itens em Estoque', 'patrimonio_patrimonial_relatorios_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_relatorios_movimentacao', 'Movimentação', 'patrimonio_patrimonial_relatorios_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->removeRoute('urbem_patrimonial_almoxarifado_relatorios_itens_estoque', 'patrimonio_patrimonial_relatorios_home');
        $this->removeRoute('urbem_patrimonial_almoxarifado_relatorios_movimentacao', 'patrimonio_patrimonial_relatorios_home');
        $this->removeRoute('patrimonio_almoxarifado_relatorios_home', 'patrimonial');
    }
}
