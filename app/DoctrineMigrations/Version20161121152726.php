<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Class Version20161121152726
 * @package Application\Migrations
 *
 * Migration para gerar sequences para as tabelas Frota.Marca, Frota.TipoVeiculo e Frota.Combustivel
 */
class Version20161121152726 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS frota.marca_seq");
        $this->addSql("CREATE SEQUENCE frota.marca_seq START 1");
        $this->addSql("SELECT setval(
            'frota.marca_seq',
            COALESCE((SELECT MAX(cod_marca)+1 FROM frota.marca), 1),
            false
        );");

        $this->addSql("DROP SEQUENCE IF EXISTS frota.tipo_veiculo_seq");
        $this->addSql("CREATE SEQUENCE frota.tipo_veiculo_seq START 1");
        $this->addSql("SELECT setval(
            'frota.tipo_veiculo_seq',
            COALESCE((SELECT MAX(cod_tipo)+1 FROM frota.tipo_veiculo), 1),
            false
        );");

        $this->addSql("DROP SEQUENCE IF EXISTS frota.combustivel_seq");
        $this->addSql("CREATE SEQUENCE frota.combustivel_seq START 1");
        $this->addSql("SELECT setval(
            'frota.combustivel_seq',
            COALESCE((SELECT MAX(cod_combustivel)+1 FROM frota.combustivel), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS frota.marca_seq");
        $this->addSql("DROP SEQUENCE IF EXISTS frota.tipo_veiculo_seq");
        $this->addSql("DROP SEQUENCE IF EXISTS frota.combustivel_seq");
    }
}
