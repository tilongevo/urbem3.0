<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161130141605 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS organograma.local_cod_local_seq");
        $this->addSql("CREATE SEQUENCE organograma.local_cod_local_seq START 1");

        $this->addSql("SELECT setval(
            'organograma.local_cod_local_seq',
            COALESCE((SELECT MAX(cod_local) + 1 
                      FROM organograma.local), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS organograma.local_cod_local_seq");
    }
}
