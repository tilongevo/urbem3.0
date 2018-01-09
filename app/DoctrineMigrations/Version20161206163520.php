<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161206163520 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS public.sw_atributo_cgm_seq");
        $this->addSql("CREATE SEQUENCE public.sw_atributo_cgm_seq START 1");
        $this->addSql("
        SELECT
        setval (
            'public.sw_atributo_cgm_seq',
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
        $this->addSql("DROP SEQUENCE IF EXISTS public.sw_atributo_cgm_seq");
    }
}
