<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoExcluido;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedido;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170608130856 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('BEGIN;');
        $this->changeColumnToDateTimeMicrosecondType(AdidoCedidoExcluido::class, 'timestamp_cedido_adido');
        $this->changeColumnToDateTimeMicrosecondType(AdidoCedidoExcluido::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AdidoCedido::class, 'timestamp');
        $this->addSql('COMMIT;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
