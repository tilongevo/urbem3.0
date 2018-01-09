<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170331182935 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.especialidade_cod_especialidade_seq");
        $this->addSql("CREATE SEQUENCE pessoal.especialidade_cod_especialidade_seq START 1");
        $this->addSql("select setval('pessoal.especialidade_cod_especialidade_seq',coalesce((select max(cod_especialidade) + 1 from pessoal.especialidade), 1), false);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS pessoal.especialidade_cod_especialidade_seq");
    }
}
