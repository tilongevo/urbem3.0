<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Tesouraria\Autenticacao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170227152016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Autenticacao::class, 'dt_autenticacao');
        $this->addSql("ALTER TABLE tesouraria.transacoes_pagamento ALTER COLUMN documento TYPE varchar(100) USING documento::varchar;");
        $this->addSql("ALTER TABLE tesouraria.transacoes_pagamento ALTER COLUMN documento DROP NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.transacoes_pagamento ALTER COLUMN documento DROP DEFAULT;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
