<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161128141801 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS compras.objeto_seq");
        $this->addSql("CREATE SEQUENCE compras.objeto_seq START 1");
        $this->addSql("
        SELECT
        setval (
            'compras.objeto_seq',
            COALESCE (
                (
                    SELECT
                        max (
                            cod_objeto )
                        + 1
                    FROM
                        compras.objeto ),
                1 ),
            FALSE );
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS compras.objeto_seq");
    }
}
