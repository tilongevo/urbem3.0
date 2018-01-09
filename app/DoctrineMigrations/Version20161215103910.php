<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161215103910 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.ocorrencia_seq");
        $this->addSql("CREATE SEQUENCE pessoal.ocorrencia_seq START 1");

        $this->addSql("SELECT setval(
            'pessoal.ocorrencia_seq',
            COALESCE((SELECT MAX(cod_ocorrencia) + 1
                      FROM pessoal.ocorrencia), 1),
            FALSE
            );
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.ocorrencia_seq");
    }
}
