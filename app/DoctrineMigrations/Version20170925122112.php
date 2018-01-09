<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170925122112 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Incluir Crédito' WHERE descricao_rota = 'urbem_tributario_monetario_credito_create'");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Alterar Crédito' WHERE descricao_rota = 'urbem_tributario_monetario_credito_edit'");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Excluir Crédito' WHERE descricao_rota = 'urbem_tributario_monetario_credito_delete'");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Detalhe Crédito' WHERE descricao_rota = 'urbem_tributario_monetario_credito_show'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
