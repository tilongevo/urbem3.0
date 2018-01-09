<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170620133710 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Empresa de Fato' WHERE descricao_rota = 'urbem_tributario_economico_cadastro_economico_empresa_fato_list';");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Empresa de Direito' WHERE descricao_rota = 'urbem_tributario_economico_cadastro_economico_empresa_direito_list';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
