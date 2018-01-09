<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Ppa\MacroObjetivo;
use Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170109095745 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("UPDATE ppa.programa_setorial SET \"timestamp\"='2016-08-25 11:39:43'");
        $this->addSql("UPDATE ppa.macro_objetivo SET \"timestamp\"='2016-08-25 11:39:43'");
        $this->changeColumnToDateTimeMicrosecondType(ProgramaSetorial::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(MacroObjetivo::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
