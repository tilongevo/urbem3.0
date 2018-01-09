<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170707150409 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoHsbcBancos::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoHsbcOrgao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoHsbcLocal::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoHsbcConta::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
