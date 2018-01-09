<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170221112700 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('ALTER TABLE almoxarifado.requisicao_homologada ALTER COLUMN "timestamp" TYPE TIMESTAMP;');
        $this->addSql('ALTER TABLE almoxarifado.requisicao_homologada ALTER COLUMN "timestamp" SET DEFAULT CURRENT_TIMESTAMP(3);');
        $this->addSql('COMMENT ON COLUMN almoxarifado.requisicao_homologada.timestamp IS NULL;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );
    }
}
