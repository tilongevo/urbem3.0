<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161206104405 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS ima.configuracaobanparaempresa_seq");
        $this->addSql("CREATE SEQUENCE ima.configuracaobanparaempresa_seq START 1");

        $this->addSql("SELECT setval(
            'ima.configuracaobanparaempresa_seq',
            COALESCE((SELECT MAX(cod_empresa) + 1
                      FROM ima.configuracao_banpara_empresa), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS ima.configuracaobanparaempresa_seq");
    }
}
