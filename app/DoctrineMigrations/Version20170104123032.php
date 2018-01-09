<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170104123032 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createSequence('calendario.feriado_cod_feriado_seq', 'calendario', 'feriado', 'cod_feriado');
        $this->createSequence('calendario.calendario_cadastro_cod_calendar_seq', 'calendario', 'calendario_cadastro', 'cod_calendar');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->dropSequence('calendario.feriado_cod_feriado_seq');
        $this->dropSequence('calendario.calendario_cadastro_cod_calendar_seq');
    }
}
