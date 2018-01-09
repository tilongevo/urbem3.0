<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170710182948 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_pessoal_ferias_conceder_list', 'Conceder', 'pessoal_ferias_home');
        $this->insertRoute('urbem_recursos_humanos_pessoal_ferias_conceder_edit', 'Conceder', 'pessoal_ferias_home');
        $this->insertRoute('urbem_recursos_humanos_pessoal_ferias_conceder_create', 'Conceder', 'pessoal_ferias_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
