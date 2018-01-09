<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170620144221 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->removeRoute('configuracao_homepage', 'home-urbem');
        $this->removeRoute('configuracao_edit', 'configuracao_homepage');
        $this->removeRoute('autocomplete', 'home-urbem');

        $this->insertRoute('configuracao_homepage', 'Configuração', 'home-urbem');
        $this->insertRoute('configuracao_edit', 'Edição', 'configuracao_homepage');
        $this->insertRoute('autocomplete', 'Autocomplete', 'home-urbem');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->removeRoute('configuracao_homepage', 'home-urbem');
        $this->removeRoute('configuracao_edit', 'configuracao_homepage');
        $this->removeRoute('autocomplete', 'home-urbem');
    }
}
