<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170214095749 extends AbstractMigration
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

        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Transporte Escolar' WHERE descricao_rota = 'urbem_patrimonial_frota_transporte_escolar_list';");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Controle Escolar' WHERE descricao_rota = 'patrimonio_frota_controle_escolar_home';");
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
