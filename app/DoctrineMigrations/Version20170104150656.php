<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170104150656 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->changeColumnToTimeMicrosecondType(Empenho::class, 'hora');
        $this->changeColumnToTimeMicrosecondType(NotaLiquidacao::class, 'hora');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
