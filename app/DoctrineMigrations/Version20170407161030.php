<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170407161030 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP SEQUENCE IF EXISTS folhapagamento.vinculo_seq CASCADE');
        $this->addSql('CREATE SEQUENCE folhapagamento.vinculo_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql("SELECT setval(
            'folhapagamento.vinculo_seq',
            COALESCE((SELECT MAX(cod_vinculo)+1 FROM folhapagamento.vinculo), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
