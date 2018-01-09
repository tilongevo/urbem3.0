<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171228150547 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("
            CREATE TABLE tcepr.cadastro_secretario (
              num_cadastro INTEGER NOT NULL,
              cod_orgao INTEGER NOT NULL,
              exercicio VARCHAR(4) NOT NULL,
              numcgm INTEGER NOT NULL,
              cod_norma INTEGER NOT NULL,
              dt_inicio_vinculo DATE NOT NULL,
              PRIMARY KEY (num_cadastro, cod_orgao, exercicio, numcgm),
              FOREIGN KEY (cod_orgao) REFERENCES organograma.orgao (cod_orgao),
              FOREIGN KEY (numcgm) REFERENCES sw_cgm_pessoa_fisica (numcgm),
              FOREIGN KEY (cod_norma) REFERENCES normas.norma (cod_norma)
            );
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP TABLE tcepr.cadastro_secretario");
    }
}
