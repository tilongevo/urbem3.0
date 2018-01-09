<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161208150609 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS compras.fornecedor_socio_seq");
        $this->addSql("CREATE SEQUENCE compras.fornecedor_socio_seq");

        $this->addSql("SELECT setval(
            'compras.fornecedor_socio_seq',
            COALESCE((SELECT MAX(id) + 1 FROM compras.fornecedor_socio), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS compras.fornecedor_socio_seq");
    }
}
