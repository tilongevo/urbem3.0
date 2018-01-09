<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161219123554 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createSequence('administracao.usuario_numcgm_seq', 'administracao', 'usuario', 'numcgm');
        $this->createSequence('administracao.usuario_id_seq', 'administracao', 'usuario', 'id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->createSequence('administracao.usuario_numcgm_seq', 'administracao', 'usuario', 'numcgm');
        $this->dropSequence('administracao.usuario_id_seq', 'administracao', 'usuario', 'id');

        $this->createSequence('administracao.usuario_seq', 'administracao', 'usuario', 'id');
    }
}
