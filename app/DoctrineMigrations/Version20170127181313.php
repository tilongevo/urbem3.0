<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170127181313 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection
                ->getDatabasePlatform()
                ->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->changeColumnToDateTimeMicrosecondType(PedidoTransferencia::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection
                ->getDatabasePlatform()
                ->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );
    }
}
