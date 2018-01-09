<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170123150816 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createSequence('pessoal.cod_vinculo_seq', 'pessoal', 'vinculo_empregaticio', 'cod_vinculo');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->createSequence('pessoal.cod_vinculo_seq', 'pessoal', 'vinculo_empregaticio', 'cod_vinculo');
    }
}
