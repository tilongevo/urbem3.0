<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Class Version20161205112555
 * @package Application\Migrations
 *
 * Migration para gerar sequences para a tabela Frota.Infracoa
 */
class Version20161205112555 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS frota.infracao_seq");
        $this->addSql("CREATE SEQUENCE frota.infracao_seq START 1");
        $this->addSql("SELECT setval(
            'frota.infracao_seq',
            COALESCE((SELECT MAX(id)+1 FROM frota.infracao), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS frota.infracao_seq");
    }
}
