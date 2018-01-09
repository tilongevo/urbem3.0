<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171228150550 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("
            CREATE TABLE tcepr.responsavel_modulo (
              cod_responsavel INTEGER NOT NULL,
              id_tipo_modulo INTEGER NOT NULL,
              id_tipo_responsavel_modulo INTEGER NOT NULL,
              numcgm INTEGER NOT NULL,
              dt_inicio_vinculo DATE NOT NULL,
              dt_baixa DATE DEFAULT NULL,
              motivo_baixa TEXT DEFAULT NULL,
              PRIMARY KEY (cod_responsavel),
              FOREIGN KEY (id_tipo_modulo) REFERENCES tcepr.tipo_modulo (id_tipo_modulo),
              FOREIGN KEY (id_tipo_responsavel_modulo) REFERENCES tcepr.tipo_responsavel_modulo (id_tipo_responsavel_modulo),
              FOREIGN KEY (numcgm) REFERENCES sw_cgm (numcgm)
            );
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP TABLE tcepr.responsavel_modulo");
    }
}
