<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171017111604 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->updateUpperRoute('Tesoureria - Outras Operações', 'Tesouraria - Outras Operações');
        $this->addSql("UPDATE administracao.rota SET traducao_rota = :title WHERE traducao_rota = :oldTitle", ['title' => 'Tesouraria - Outras Operações', 'oldTitle' => 'Tesoureria - Outras Operações']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
