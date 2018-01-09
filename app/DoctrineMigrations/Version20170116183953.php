<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170116183953 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createSequence('beneficio.linha_cod_linha_seq', 'beneficio', 'linha', 'cod_linha');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->dropSequence('beneficio.linha_cod_linha_seq', 'beneficio', 'linha', 'cod_linha');
    }
}
