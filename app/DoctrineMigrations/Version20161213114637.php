<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161213114637 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE contabilidade.plano_conta ALTER COLUMN cod_sistema TYPE int4 USING cod_sistema::int4");
        $this->addSql("ALTER TABLE contabilidade.plano_conta ALTER COLUMN cod_sistema DROP NOT NULL");
        $this->addSql("ALTER TABLE contabilidade.plano_conta ALTER COLUMN cod_sistema DROP DEFAULT");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE contabilidade.plano_conta ALTER COLUMN cod_sistema TYPE int4 USING cod_sistema::int4");
        $this->addSql("ALTER TABLE contabilidade.plano_conta ALTER COLUMN cod_sistema SET NOT NULL");
        $this->addSql("ALTER TABLE contabilidade.plano_conta ALTER COLUMN cod_sistema DROP DEFAULT");
    }
}
