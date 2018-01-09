<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para configurar o sequence de Frota.VeiculoCessao
 */
class Version20161130174521 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS frota.veiculo_cessao_seq");
        $this->addSql("CREATE SEQUENCE frota.veiculo_cessao_seq START 1");

        $this->addSql("SELECT setval(
            'frota.veiculo_cessao_seq',
            COALESCE((SELECT MAX(id) + 1 
                      FROM frota.veiculo_cessao), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS frota.veiculo_cessao_seq");
    }
}
