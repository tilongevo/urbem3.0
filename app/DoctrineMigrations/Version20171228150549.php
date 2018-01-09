<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171228150549 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("
            CREATE TABLE tcepr.secretaria_x_orgao (
              cod_orgao INTEGER NOT NULL,
              exercicio VARCHAR(4) NOT NULL,
              id_secretaria_tce INTEGER NOT NULL,
              dt_cadastro DATE NOT NULL,
              UNIQUE(id_secretaria_tce, exercicio),
              PRIMARY KEY (cod_orgao, exercicio, id_secretaria_tce),
              FOREIGN KEY (cod_orgao) REFERENCES organograma.orgao (cod_orgao)
            );
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP TABLE tcepr.secretaria_x_orgao");
    }
}
