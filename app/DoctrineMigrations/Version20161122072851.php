<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161122072851 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS public.sw_historico_arquivamento_cod_historico_seq");
        $this->addSql("CREATE SEQUENCE public.sw_historico_arquivamento_cod_historico_seq START 1");

        $this->addSql("SELECT setval(
            'public.sw_historico_arquivamento_cod_historico_seq',
            COALESCE((SELECT MAX(cod_historico)+1 FROM public.sw_historico_arquivamento), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS public.sw_historico_arquivamento_cod_historico_seq");
    }
}
