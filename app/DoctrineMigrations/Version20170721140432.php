<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170721140432 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Orçamento - Classificação Institucional' WHERE descricao_rota = 'urbem_financeiro_orcamento_classificacao_institucional_list'");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Incluir' WHERE descricao_rota = 'urbem_financeiro_orcamento_classificacao_institucional_create'");
        $this->addSql("DELETE FROM administracao.rota WHERE cod_rota IN (SELECT cod_rota FROM administracao.rota WHERE descricao_rota = 'urbem_financeiro_orcamento_classificacao_institucional_edit' AND traducao_rota = 'Anular')");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Editar' WHERE descricao_rota = 'urbem_financeiro_orcamento_classificacao_institucional_edit'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
