<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170306204630 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('pessoal.cod_regime_seq', 'pessoal', 'regime', 'cod_regime');
        $this->createSequence('pessoal.cod_sub_divisao_seq', 'pessoal', 'sub_divisao', 'cod_sub_divisao');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->dropSequence('pessoal.cod_regime_seq', 'pessoal', 'regime', 'cod_regime');
        $this->dropSequence('pessoal.cod_sub_divisao_seq', 'pessoal', 'sub_divisao', 'cod_sub_divisao');
    }
}
