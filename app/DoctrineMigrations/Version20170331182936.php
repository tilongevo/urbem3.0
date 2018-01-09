<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170331182936 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("
        ALTER TABLE pessoal.especialidade_padrao ALTER COLUMN TIMESTAMP TYPE TIMESTAMP (3)
        USING to_char(TIMESTAMP,
            'YYYY-MM-DD HH24:MI:SS.MS')::TIMESTAMP (3);
        ");
        $this->addSql("
        UPDATE
            pessoal.especialidade_padrao
        SET
            \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';
        ");

        $this->addSql("
        ALTER TABLE pessoal.cbo_especialidade ALTER COLUMN TIMESTAMP TYPE TIMESTAMP (3)
        USING to_char(TIMESTAMP,
            'YYYY-MM-DD HH24:MI:SS.MS')::TIMESTAMP (3);
        ");
        $this->addSql("
        UPDATE
            pessoal.cbo_especialidade
        SET
            \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';
        ");

        $this->addSql("
        ALTER TABLE pessoal.especialidade_sub_divisao ALTER COLUMN TIMESTAMP TYPE TIMESTAMP (3)
        USING to_char(TIMESTAMP,
            'YYYY-MM-DD HH24:MI:SS.MS')::TIMESTAMP (3);
        ");
        $this->addSql("
        UPDATE
            pessoal.especialidade_sub_divisao
        SET
            \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';
        ");

        $this->addSql("
        ALTER TABLE pessoal.cargo_sub_divisao ALTER COLUMN TIMESTAMP TYPE TIMESTAMP (3)
        USING to_char(TIMESTAMP,
            'YYYY-MM-DD HH24:MI:SS.MS')::TIMESTAMP (3);
        ");
        $this->addSql("
        UPDATE
            pessoal.cargo_sub_divisao
        SET
            \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';
        ");

        $this->addSql("
        ALTER TABLE pessoal.cbo_cargo ALTER COLUMN TIMESTAMP TYPE TIMESTAMP (3)
        USING to_char(TIMESTAMP,
            'YYYY-MM-DD HH24:MI:SS.MS')::TIMESTAMP (3);
        ");
        $this->addSql("
        UPDATE
            pessoal.cbo_cargo
        SET
            \"timestamp\" = \"timestamp\" + INTERVAL '543210 microsecond';
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
