<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170605153309 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE divida.modalidade_vigencia ALTER COLUMN cod_forma_inscricao TYPE int4 USING cod_forma_inscricao::int4;');
        $this->addSql('ALTER TABLE divida.modalidade_vigencia ALTER COLUMN cod_forma_inscricao DROP NOT NULL;');
        $this->addSql('ALTER TABLE divida.modalidade_vigencia ALTER COLUMN cod_forma_inscricao DROP DEFAULT;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
