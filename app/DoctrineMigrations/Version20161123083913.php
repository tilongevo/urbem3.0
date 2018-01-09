<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161123083913 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS public.sw_classificacao_cod_classificacao_seq");
        $this->addSql("CREATE SEQUENCE public.sw_classificacao_cod_classificacao_seq START 1");
        $this->addSql("SELECT setval(
            'public.sw_classificacao_cod_classificacao_seq',
            COALESCE((SELECT MAX(cod_classificacao)+1 FROM public.sw_classificacao), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS public.sw_classificacao_cod_classificacao_seq");
    }
}
