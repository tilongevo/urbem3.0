<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo;
use Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170711183108 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(RegistroEvento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LogErroCalculo::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ReajusteRegistroEvento::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(RegistroEvento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ReajusteRegistroEvento::class, 'timestamp');
    }
}
