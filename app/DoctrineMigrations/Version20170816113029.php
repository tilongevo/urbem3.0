<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170816113029 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("update pessoal.contrato_servidor_forma_pagamento set \"timestamp\" = now() where \"timestamp\" = '1900-01-01 00:00:00';");
        $this->addSql("update pessoal.contrato_servidor_previdencia set \"timestamp\" = now() where \"timestamp\" = '1900-01-01 00:00:00';");
        $this->addSql("update folhapagamento.padrao_padrao set \"timestamp\" = now() where \"timestamp\" = '1900-01-01 00:00:00';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("update pessoal.contrato_servidor_forma_pagamento set \"timestamp\" = now() where \"timestamp\" = '1900-01-01 00:00:00';");
        $this->addSql("update pessoal.contrato_servidor_previdencia set \"timestamp\" = now() where \"timestamp\" = '1900-01-01 00:00:00';");
        $this->addSql("update folhapagamento.padrao_padrao set \"timestamp\" = now() where \"timestamp\" = '1900-01-01 00:00:00';");
    }
}
