<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161125150209 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS estagio.cod_area_conhecimento_seq");
        $this->addSql("CREATE SEQUENCE estagio.cod_area_conhecimento_seq START 1");
        $this->addSql("
        SELECT
        setval (
            'estagio.cod_area_conhecimento_seq',
            COALESCE (
                (
                    SELECT
                        max (
                            cod_area_conhecimento )
                        + 1
                    FROM
                        estagio.area_conhecimento ),
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
        $this->addSql("DROP SEQUENCE IF EXISTS estagio.cod_area_conhecimento_seq");
    }
}
