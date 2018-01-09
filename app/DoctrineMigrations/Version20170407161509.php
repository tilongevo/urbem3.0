<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170407161509 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP SEQUENCE IF EXISTS folhapagamento.regime_previdencia_seq CASCADE');
        $this->addSql('CREATE SEQUENCE folhapagamento.regime_previdencia_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql("SELECT setval(
            'folhapagamento.regime_previdencia_seq',
            COALESCE((SELECT MAX(cod_regime_previdencia)+1 FROM folhapagamento.regime_previdencia), 1),
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
