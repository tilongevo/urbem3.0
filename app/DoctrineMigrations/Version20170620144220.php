<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170620144220 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql(
            "CREATE TABLE public.transparencia_exportacao (
              id INTEGER NOT NULL PRIMARY KEY,
              timestamp TIMESTAMP DEFAULT ('now'::TEXT)::TIMESTAMP(3) WITH TIME ZONE NOT NULL,
              arquivo VARCHAR NOT NULL,
              status INTEGER NOT NULL
            );"
        );

        $this->createSequence('public.transparencia_exportacao_id_seq', 'public', 'transparencia_exportacao', 'id');

        $this->addSql("ALTER TABLE public.transparencia_exportacao ALTER COLUMN id SET DEFAULT NEXTVAL('public.transparencia_exportacao_id_seq');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->dropSequence('public.transparencia_exportacao_id_seq', 'public', 'transparencia_exportacao', 'id');
        $this->addSql("DROP TABLE IF EXISTS public.transparencia_exportacao;");
    }
}
