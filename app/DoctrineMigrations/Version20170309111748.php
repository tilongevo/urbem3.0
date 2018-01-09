<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170309111748 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute("urbem_patrimonial_compras_configuracao_list");
        $this->insertRoute(
            "urbem_patrimonial_compras_configuracao_list",
            "Compras - Configuração",
            "patrimonial"
        );
        $this->removeRoute("urbem_patrimonial_compras_configuracao_show");
        $this->insertRoute(
            "urbem_patrimonial_compras_configuracao_show",
            "Responsável",
            "urbem_patrimonial_compras_configuracao_list"
        );
        $this->removeRoute("urbem_patrimonial_compras_configuracao_entidade_create");
        $this->insertRoute(
            "urbem_patrimonial_compras_configuracao_entidade_create",
            "Responsável - Novo",
            "urbem_patrimonial_compras_configuracao_list"
        );
        $this->removeRoute("urbem_patrimonial_compras_configuracao_entidade_delete");
        $this->insertRoute(
            "urbem_patrimonial_compras_configuracao_entidade_delete",
            "Responsável - Apagar",
            "urbem_patrimonial_compras_configuracao_list"
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
