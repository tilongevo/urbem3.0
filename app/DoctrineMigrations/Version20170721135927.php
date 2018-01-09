<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170721135927 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoBescConta::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoBescLocal::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoBescOrgao::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
