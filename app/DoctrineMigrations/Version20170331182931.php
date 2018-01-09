<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170331182931 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.cargo_seq");
        $this->addSql("CREATE SEQUENCE pessoal.cargo_seq START 1");
        $this->addSql("select setval('pessoal.cargo_seq',coalesce((select max(cod_cargo) + 1 from pessoal.cargo), 1), false);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.cargo_seq");
    }
}
