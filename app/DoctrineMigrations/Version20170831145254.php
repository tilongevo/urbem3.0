<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170831145254 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("delete from pessoal.contrato_pensionista_previdencia where cod_contrato = 883 and \"timestamp\" = '1900-01-01 00:00:00';");
        $this->addSql("update pessoal.contrato_pensionista_previdencia set timestamp = (SELECT timestamptz '2009-01-01 00:00:0000' +
                            random() * (timestamptz '2017-01-01 00:00:0000' -
                                        timestamptz '2009-02-10 00:00:0000')) where cod_contrato in (883, 882);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
