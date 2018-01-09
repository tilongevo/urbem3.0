<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170109160305 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Arrecadacao::class, 'timestamp_arrecadacao');
        $this->changeColumnToDateTimeMicrosecondType(ArrecadacaoEstornadaReceita::class, 'timestamp_estornada');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
