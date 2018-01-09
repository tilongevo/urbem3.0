<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161121130653 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS compras.objeto_seq");
        $this->addSql("DROP SEQUENCE IF EXISTS normas.tipo_norma_seq");

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("CREATE SEQUENCE compras.objeto_seq START 73");
        $this->addSql("CREATE SEQUENCE normas.tipo_norma_seq START 1");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS compras.objeto_seq");
        $this->addSql("DROP SEQUENCE IF EXISTS normas.tipo_norma_seq");
    }
}
