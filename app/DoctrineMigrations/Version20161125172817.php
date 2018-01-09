<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161125172817 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS estagio.cod_grau_seq");
        $this->addSql("CREATE SEQUENCE estagio.cod_grau_seq START 1");
        $this->addSql("
        SELECT
        setval (
            'estagio.cod_grau_seq',
            COALESCE (
                (
                    SELECT
                        max (
                            cod_grau )
                        + 1
                    FROM
                        estagio.grau ),
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
        $this->addSql("DROP SEQUENCE IF EXISTS estagio.cod_grau_seq");
    }
}
