<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161212181204 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("ALTER TABLE organograma.orgao_descricao ALTER COLUMN timestamp TYPE timestamp(3) using to_char(timestamp, 'YYYY-MM-DD HH24:MI:SS.MS')::timestamp(3);");
        $this->addSql("update organograma.orgao_descricao set \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';");
        $this->addSql("COMMENT ON COLUMN organograma.orgao_descricao.timestamp IS '(DC2Type:datetimemicrosecondpk)';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
