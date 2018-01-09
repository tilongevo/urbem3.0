<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170516104844 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('divida.divida_cod_autoridade_seq', 'divida', 'autoridade', 'cod_autoridade');
        $this->addSql('ALTER TABLE divida.autoridade ALTER COLUMN tipo_assinatura TYPE varchar(255) USING tipo_assinatura::varchar;');
        $this->addSql('ALTER TABLE divida.autoridade ALTER COLUMN tipo_assinatura SET NOT NULL;');
        $this->addSql('ALTER TABLE divida.autoridade ALTER COLUMN tipo_assinatura DROP DEFAULT;');
        $this->addSql('ALTER TABLE divida.autoridade ALTER COLUMN assinatura DROP NOT NULL;');
        $this->addSql('ALTER TABLE divida.autoridade ALTER COLUMN assinatura DROP DEFAULT;');
        $this->addSql('ALTER TABLE divida.autoridade ALTER COLUMN tamanho_assinatura TYPE int4 USING tamanho_assinatura::int4;');
        $this->addSql('ALTER TABLE divida.autoridade ALTER COLUMN tamanho_assinatura DROP NOT NULL;');
        $this->addSql('ALTER TABLE divida.autoridade ALTER COLUMN tamanho_assinatura DROP DEFAULT;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->dropSequence('divida.divida_cod_autoridade_seq', 'divida', 'divida', 'cod_autoridade');
    }
}
