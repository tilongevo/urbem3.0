<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Frota\ManutencaoAnulacao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para mudar a coluna Timestamp da tabelas Frota.ManutencaoAnulacao para DateTimeMicrosecondPk
 */
class Version20170112135148 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(ManutencaoAnulacao::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
