<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Almoxarifado\InventarioAnulacao;
use Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170303140413 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(InventarioAnulacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(InventarioItens::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
