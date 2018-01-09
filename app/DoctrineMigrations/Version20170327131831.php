<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170327131831 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Novo', rota_superior = 'urbem_patrimonial_licitacao_publicidade_list' WHERE descricao_rota = 'urbem_patrimonial_licitacao_publicidade_create';");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Veículos de Publicidade', rota_superior = 'patrimonial' WHERE descricao_rota = 'urbem_patrimonial_licitacao_publicidade_list';");
        $this->addSql("DROP SEQUENCE IF EXISTS licitacao.cod_documento_seq");
        $this->addSql("CREATE SEQUENCE licitacao.cod_documento_seq START 1");
        $this->addSql("SELECT setval(
            'licitacao.cod_documento_seq',
            COALESCE((SELECT MAX(cod_documento)+1 FROM licitacao.documento), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP SEQUENCE IF EXISTS licitacao.cod_documento_seq");
    }
}
