<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para configurar o sequence de Frota.VeiculoLocacao
 */
class Version20161130154634 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS frota.veiculo_locacao_seq");
        $this->addSql("CREATE SEQUENCE frota.veiculo_locacao_seq START 1");

        $this->addSql("SELECT setval(
            'frota.veiculo_locacao_seq',
            COALESCE((SELECT MAX(id) + 1
                      FROM frota.veiculo_locacao), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS frota.veiculo_locacao_seq");
    }
}
