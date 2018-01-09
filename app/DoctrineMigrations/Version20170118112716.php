<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170118112716 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP INDEX IF EXISTS licitacao.ck_licitacao_publicacao_convenio');
        $this->addSql('CREATE INDEX ck_licitacao_publicacao_convenio ON licitacao.publicacao_convenio USING btree (exercicio, num_convenio, numcgm, dt_publicacao)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP INDEX IF EXISTS licitacao.ck_licitacao_publicacao_convenio');
    }
}
