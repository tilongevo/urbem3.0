<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161125164955 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.apolice_seq");
        $this->addSql("CREATE SEQUENCE patrimonio.apolice_seq START 1");
        $this->addSql("
        SELECT
        setval (
            'patrimonio.apolice_seq',
            COALESCE (
                (
                    SELECT
                        max (
                            cod_apolice )
                        + 1
                    FROM
                        patrimonio.apolice ),
                1 ),
            FALSE );
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS patrimonio.apolice_seq");
    }
}
