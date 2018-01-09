<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Ldo\AcaoValidada;
use Urbem\CoreBundle\Entity\Ppa\AcaoNorma;
use Urbem\CoreBundle\Entity\Ppa\AcaoPeriodo;
use Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170127135533 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(AcaoValidada::class, 'timestamp_acao_dados');
        $this->changeColumnToDateTimeMicrosecondType(AcaoNorma::class, 'timestamp_acao_dados');
        $this->changeColumnToDateTimeMicrosecondType(AcaoUnidadeExecutora::class, 'timestamp_acao_dados');
        $this->changeColumnToDateTimeMicrosecondType(AcaoPeriodo::class, 'timestamp_acao_dados');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
