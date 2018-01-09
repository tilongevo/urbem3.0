<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161207104937 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $sql = 'select count(column_name) as total 
                from information_schema.columns 
                where table_schema = \'pessoal\' 
                and table_name = \'assentamento_assentamento\'
                and column_name = \'cod_regime_previdencia\';';

        if (!$this->connection->query($sql)->fetch()['total']) {
            $this->addSql('ALTER TABLE pessoal.assentamento_assentamento ADD COLUMN cod_regime_previdencia int4 NULL DEFAULT NULL;');
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $sql = 'select count(column_name) as total 
                from information_schema.columns 
                where table_schema = \'pessoal\' 
                and table_name = \'assentamento_assentamento\'
                and column_name = \'cod_regime_previdencia\';';

        if ($this->connection->query($sql)->fetch()['total'] > 0) {
            $this->addSql('ALTER TABLE pessoal.assentamento_assentamento DROP COLUMN cod_regime_previdencia;');
        }
    }
}
