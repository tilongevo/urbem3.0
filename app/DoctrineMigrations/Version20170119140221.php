<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170119140221 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS ppa.regiao_seq");
        $this->addSql("CREATE SEQUENCE ppa.regiao_seq START 1");
        $this->addSql("select setval('ppa.regiao_seq',coalesce((select max(cod_regiao) + 1 from ppa.regiao), 1), false);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS ppa.regiao_seq");
    }
}
