<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170117172804 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN cod_unidade TYPE int4 USING cod_unidade::int4');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN cod_unidade DROP NOT NULL');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN cod_unidade DROP DEFAULT');

        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN cod_grandeza TYPE int4 USING cod_grandeza::int4');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN cod_grandeza DROP NOT NULL');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN cod_grandeza DROP DEFAULT');

        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN nom_unidade TYPE varchar(80) USING nom_unidade::varchar');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN nom_unidade DROP NOT NULL');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN nom_unidade DROP DEFAULT');

        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN sigla_unidade TYPE varchar(20) USING sigla_unidade::varchar');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN sigla_unidade DROP NOT NULL');
        $this->addSql('ALTER TABLE empenho.item_pre_empenho ALTER COLUMN sigla_unidade DROP DEFAULT');

        $this->addSql('ALTER TABLE empenho.pre_empenho ALTER COLUMN cod_historico TYPE int4 USING cod_historico::int4');
        $this->addSql('ALTER TABLE empenho.pre_empenho ALTER COLUMN cod_historico DROP NOT NULL');
        $this->addSql('ALTER TABLE empenho.pre_empenho ALTER COLUMN cod_historico DROP DEFAULT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
