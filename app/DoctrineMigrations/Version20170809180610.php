<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170809180610 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("ALTER TABLE divida.divida_estorno ALTER COLUMN timestamp TYPE timestamp(3) using to_char(timestamp, 'YYYY-MM-DD HH24:MI:SS.MS')::timestamp(3);");
        $this->addSql("update divida.divida_estorno set \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';");
        $this->addSql("COMMENT ON COLUMN divida.divida_estorno.timestamp IS '(DC2Type:datetimemicrosecondpk)';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
