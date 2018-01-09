<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170127154356 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createSequence('folhapagamento.cod_configuracao_seq', 'folhapagamento', 'configuracao_totais_folha', 'cod_configuracao');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->dropSequence('folhapagamento.cod_configuracao_seq', 'folhapagamento', 'configuracao_totais_folha', 'cod_configuracao');
    }
}
