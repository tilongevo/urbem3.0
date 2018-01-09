<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170623135429 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('home-portalservicos', 'Portal de Serviços', null);
        $this->addSql("UPDATE administracao.rota SET traducao_rota = 'Início' WHERE administracao.rota.descricao_rota = 'home-urbem'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('home-portalservicos', null);
        $this->addSql("UPDATE administracao.rota SET traducao_rota = '' WHERE administracao.rota.descricao_rota = 'home-urbem'");
    }
}
