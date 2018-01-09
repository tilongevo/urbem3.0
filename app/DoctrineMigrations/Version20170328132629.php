<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170328132629 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("UPDATE administracao.rota SET rota_superior = 'urbem_patrimonial_licitacao_publicidade_list', traducao_rota = 'Editar' WHERE descricao_rota = 'urbem_patrimonial_licitacao_publicidade_edit';");
        $this->addSql("UPDATE administracao.rota SET rota_superior = 'urbem_patrimonial_licitacao_publicidade_list', traducao_rota = 'Remover' WHERE descricao_rota = 'urbem_patrimonial_licitacao_publicidade_delete';");
        $this->addSql("UPDATE administracao.rota SET rota_superior = 'urbem_patrimonial_licitacao_publicidade_list', traducao_rota = 'Detalhes' WHERE descricao_rota = 'urbem_patrimonial_licitacao_publicidade_show';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
