<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Frota\Proprio;
use Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade;
use Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para mudar a coluna Timestamp da tabelas VeiculoPropriedade, Proprio e VeiculoTerceirosResponsavel
 * para DateTimeMicrosecondPk
 */
class Version20170109121357 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->changeColumnToDateTimeMicrosecondType(VeiculoPropriedade::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Proprio::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(VeiculoTerceirosResponsavel::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
