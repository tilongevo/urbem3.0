<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161130092315 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS sw_atributo_protocolo_cod_atributo_seq");
        $this->addSql("CREATE SEQUENCE sw_atributo_protocolo_cod_atributo_seq START 1");

        $this->addSql("SELECT setval(
            'sw_atributo_protocolo_cod_atributo_seq',
            COALESCE((SELECT MAX(cod_atributo) + 1 
                      FROM sw_atributo_protocolo), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS sw_atributo_protocolo_cod_atributo_seq");
    }
}
