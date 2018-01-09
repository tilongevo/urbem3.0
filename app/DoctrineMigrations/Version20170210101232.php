<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170210101232 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->removeRoute('urbem_patrimonial_almoxarifado_entrada_doacao_list', 'patrimonial_almoxarifado_entrada_home');
        $this->removeRoute('urbem_patrimonial_almoxarifado_entrada_diversos_list', 'patrimonial_almoxarifado_entrada_home');
        $this->removeRoute('urbem_patrimonial_almoxarifado_entrada_doacao_show', 'urbem_patrimonial_almoxarifado_entrada_doacao_list');
        $this->removeRoute('urbem_patrimonial_almoxarifado_entrada_diversos_show', 'urbem_patrimonial_almoxarifado_entrada_diversos_list');

        $this->updateUpperRoute('urbem_patrimonial_almoxarifado_entrada_doacao_create', 'patrimonial_almoxarifado_entrada_home');
        $this->updateUpperRoute('urbem_patrimonial_almoxarifado_entrada_diversos_create', 'patrimonial_almoxarifado_entrada_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );
    }
}
