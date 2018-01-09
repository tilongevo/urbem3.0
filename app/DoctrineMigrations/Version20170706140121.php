<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170706140121 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("UPDATE administracao.rota SET rota_superior = null WHERE descricao_rota = :descricao_rota", [
            'descricao_rota' => 'acesso-negado'
        ]);

        $this->addSql("UPDATE administracao.rota SET rota_superior = null WHERE descricao_rota = :descricao_rota", [
            'descricao_rota' => 'rota-nao-encontrada'
        ]);

        $this->addSql("UPDATE administracao.rota SET rota_superior = null WHERE descricao_rota = :descricao_rota", [
            'descricao_rota' => 'autocomplete'
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("UPDATE administracao.rota SET rota_superior = 'home-urbem' WHERE descricao_rota = :descricao_rota", [
            'descricao_rota' => 'acesso-negado'
        ]);

        $this->addSql("UPDATE administracao.rota SET rota_superior = 'home-urbem' WHERE descricao_rota = :descricao_rota", [
            'descricao_rota' => 'rota-nao-encontrada'
        ]);

        $this->addSql("UPDATE administracao.rota SET rota_superior = 'home-urbem' WHERE descricao_rota = :descricao_rota", [
            'descricao_rota' => 'autocomplete'
        ]);
    }
}
