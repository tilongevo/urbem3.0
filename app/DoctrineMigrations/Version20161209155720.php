<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161209155720 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE pessoal.aposentadoria ALTER COLUMN \"timestamp\" TYPE timestamp(3) using to_char(timestamp, 'YYYY-MM-DD HH24:MI:SS.MS')::timestamp(3);");
        $this->addSql("ALTER TABLE pessoal.aposentadoria ALTER COLUMN \"timestamp\" SET NOT NULL");
        $this->addSql("ALTER TABLE pessoal.aposentadoria ALTER COLUMN \"timestamp\" DROP DEFAULT");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        //...
    }
}
