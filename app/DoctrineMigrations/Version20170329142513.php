<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Tesouraria\TerminalDesativado;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170329142513 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(TerminalDesativado::class, 'timestamp_desativado');
        $this->removeRoute('urbem_financeiro_tesouraria_terminal_list');
        $this->insertRoute('urbem_financeiro_tesouraria_terminal_list', 'Terminal e Usuários', 'tesouraria_configuracao_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
