<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para ajustar a rota de Frota>Item da Manutenção e remover Home de Item da Manutenção
 */
class Version20170214162917 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->removeRoute('patrimonio_frota_item_manutencao_home', 'patrimonial');
        $this->removeRoute('urbem_patrimonial_frota_item_list', 'patrimonio_frota_item_manutencao_home');
        $this->insertRoute('urbem_patrimonial_frota_item_list', 'Frota - Item de Manutenção', 'patrimonial');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
