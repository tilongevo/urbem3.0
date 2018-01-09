<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170116191235 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createSequence('pessoal.cid_cod_cid_seq', 'pessoal', 'cid', 'cod_cid');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->dropSequence('pessoal.cid_cod_cid_seq', 'pessoal', 'cid', 'cod_cid');
    }
}
