<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170224153541 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('UPDATE ppa.acao SET ultimo_timestamp_acao_dados = subquery.timestamp_acao_dados FROM (SELECT cod_acao, timestamp_acao_dados FROM ppa.acao_dados order by timestamp_acao_dados desc) AS subquery WHERE ppa.acao.cod_acao = subquery.cod_acao;');
        $this->addSql('UPDATE ppa.programa SET ultimo_timestamp_programa_dados = subquery.timestamp_programa_dados FROM (SELECT cod_programa, timestamp_programa_dados FROM ppa.programa_dados order by timestamp_programa_dados desc) AS subquery WHERE programa.cod_programa = subquery.cod_programa;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
