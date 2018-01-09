<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170111170928 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('licitacao.tipo_contrato_seq', 'licitacao', 'tipo_contrato', 'cod_tipo');
        $this->createSequence('licitacao.tipo_instrumento_seq', 'licitacao', 'tipo_instrumento', 'cod_tipo');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('licitacao.tipo_contrato_seq', 'licitacao', 'tipo_contrato', 'cod_tipo');
        $this->createSequence('licitacao.tipo_instrumento_seq', 'licitacao', 'tipo_instrumento', 'cod_tipo');
    }
}
