<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170725142433 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoBbOrgao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoBbLocal::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConfiguracaoBbConta::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
