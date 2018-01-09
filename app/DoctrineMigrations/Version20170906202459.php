<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170906202459 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Incluir Atividade' WHERE descricao_rota = 'urbem_tributario_economico_atividade_economica_create';");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Alterar Atividade' WHERE descricao_rota = 'urbem_tributario_economico_atividade_economica_edit';");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Excluir Atividade' WHERE descricao_rota = 'urbem_tributario_economico_atividade_economica_delete';");
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Detalhe Atividade' WHERE descricao_rota = 'urbem_tributario_economico_atividade_economica_show';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
