<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161206141848 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS normas.tipo_norma_seq");
        $this->addSql("CREATE SEQUENCE normas.tipo_norma_seq START 1");
        $this->addSql("
        SELECT
        setval (
            'normas.tipo_norma_seq',
            COALESCE (
                (
                    SELECT
                        max (
                            cod_macro )
                        + 1
                    FROM
                        ppa.macro_objetivo ),
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
    }
}
