<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161125145708 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS ppa.programa_setorial_seq");
        $this->addSql("CREATE SEQUENCE ppa.programa_setorial_seq START 1");
        $this->addSql("
        SELECT
        setval (
            'ppa.programa_setorial_seq',
            COALESCE (
                (
                    SELECT
                        max (
                            cod_setorial )
                        + 1
                    FROM
                        ppa.programa_setorial ),
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
        $this->addSql("DROP SEQUENCE IF EXISTS ppa.programa_setorial_seq");
    }
}
