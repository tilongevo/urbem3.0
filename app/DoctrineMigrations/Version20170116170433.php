<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170116170433 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createSequence('pessoal.cbo_cod_cbo_seq', 'pessoal', 'cbo', 'cod_cbo');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->dropSequence('pessoal.cbo_cod_cbo_seq', 'pessoal', 'cbo', 'cod_cbo');
    }
}
