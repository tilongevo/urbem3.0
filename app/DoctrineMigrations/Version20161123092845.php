<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161123092845 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS public.sw_logradouro_cod_logradouro_seq");
        $this->addSql("CREATE SEQUENCE public.sw_logradouro_cod_logradouro_seq START 1");

        $this->addSql("SELECT setval(
            'public.sw_logradouro_cod_logradouro_seq',
            COALESCE((SELECT MAX(cod_logradouro)+1 FROM public.sw_cgm_logradouro), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS public.sw_logradouro_cod_logradouro_seq");
    }
}
