<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170123173743 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createSequence('pessoal.cod_classificacao_seq', 'pessoal', 'classificacao_assentamento', 'cod_classificacao');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createSequence('pessoal.cod_classificacao_seq', 'pessoal', 'classificacao_assentamento', 'cod_classificacao');
    }
}
