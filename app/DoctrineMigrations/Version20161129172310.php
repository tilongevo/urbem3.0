<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161129172310 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS sw_historico_arquivamento_cod_historico_seq");
        $this->addSql("CREATE SEQUENCE sw_historico_arquivamento_cod_historico_seq START 1");

        $this->addSql("SELECT setval(
            'sw_historico_arquivamento_cod_historico_seq',
            COALESCE((SELECT MAX(cod_historico) + 1 
                      FROM sw_historico_arquivamento), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS sw_historico_arquivamento_cod_historico_seq");
    }
}
