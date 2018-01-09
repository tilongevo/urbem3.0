<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170116144946 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE contabilidade.valor_lancamento ALTER COLUMN oid_lancamento TYPE int4 USING oid_lancamento::int4;");
        $this->addSql("ALTER TABLE contabilidade.valor_lancamento ALTER COLUMN oid_lancamento DROP NOT NULL;");
        $this->addSql("ALTER TABLE contabilidade.valor_lancamento ALTER COLUMN oid_lancamento DROP DEFAULT;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
