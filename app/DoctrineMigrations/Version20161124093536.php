<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161124093536 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS ldo.tipo_indicadores_seq");
        $this->addSql("CREATE SEQUENCE ldo.tipo_indicadores_seq START 1");
        
        $this->addSql("SELECT setval(
            'ldo.tipo_indicadores_seq',
            COALESCE((SELECT MAX(cod_tipo_indicador)+1 FROM ldo.tipo_indicadores), 1),
            false
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS ldo.tipo_indicadores_seq");
    }
}
