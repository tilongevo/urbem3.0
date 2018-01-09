<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170201092454 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS empenho.historico_seq");
        $this->addSql("CREATE SEQUENCE empenho.historico_seq START 1");
        $this->addSql("select setval('empenho.historico_seq',coalesce((select max(cod_historico) + 1 from empenho.historico), 1), false);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS empenho.historico_seq");
    }
}
