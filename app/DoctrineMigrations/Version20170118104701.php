<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170118104701 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToTimeMicrosecondType(Empenho::class, 'hora');
        $this->changeColumnToTimeMicrosecondType(NotaLiquidacao::class, 'hora');
        $this->changeColumnToTimeMicrosecondType(AutorizacaoEmpenho::class, 'hora');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
