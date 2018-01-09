<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170316195730 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("
        ALTER TABLE pessoal.contrato_pensionista_orgao ALTER COLUMN timestamp TYPE timestamp (3)
        USING to_char (timestamp, 'YYYY-MM-DD HH24:MI:SS.MS')::timestamp (3);
        ");
        $this->addSql("
        UPDATE
            pessoal.contrato_pensionista_orgao
        SET
            \"timestamp\" = \"timestamp\" + interval '543210 microsecond';
        ");
        $this->addSql("
        ALTER TABLE pessoal.contrato_pensionista_conta_salario ALTER COLUMN timestamp TYPE timestamp (3)
        USING to_char (timestamp, 'YYYY-MM-DD HH24:MI:SS.MS')::timestamp (3);
        ");
        $this->addSql("
        UPDATE
            pessoal.contrato_pensionista_conta_salario
        SET
            \"timestamp\" = \"timestamp\" + interval '543210 microsecond';
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
