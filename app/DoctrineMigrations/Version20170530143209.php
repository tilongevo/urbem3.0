<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170530143209 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_list', 'Desoneração', 'tributario_arrecadacao_desoneracao_home');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_prorrogar', 'Prorrogar', 'urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
