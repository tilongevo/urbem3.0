<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Folhapagamento\ValorDiversos;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161216101746 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->changeColumnToDateTimeMicrosecondType(ValorDiversos::class, 'timestamp');
        $this->addSql("ALTER TABLE folhapagamento.valor_diversos ALTER COLUMN \"timestamp\" SET NOT NULL");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
