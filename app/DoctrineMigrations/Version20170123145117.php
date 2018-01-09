<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170123145117 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createSequence('pessoal.cod_tipo_admissao_seq', 'pessoal', 'tipo_admissao', 'cod_tipo_admissao');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->createSequence('pessoal.cod_tipo_admissao_seq', 'pessoal', 'tipo_admissao', 'cod_tipo_admissao');
    }
}
