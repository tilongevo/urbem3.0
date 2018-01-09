<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Essa migration é uma correção da migration: Version20161206141848
 *
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170508125234 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP SEQUENCE IF EXISTS normas.tipo_norma_seq;");
        $this->createSequence('normas.tipo_norma_seq', 'normas', 'tipo_norma', 'cod_tipo_norma');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->dropSequence('normas.tipo_norma_seq', 'normas', 'tipo_norma', 'cod_tipo_norma');
    }
}
