<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Compras\CompraDiretaAnulacao;
use Urbem\CoreBundle\Entity\Compras\MapaSolicitacao;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170113133237 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('licitacao.tipo_contrato_seq', 'licitacao', 'tipo_contrato', 'cod_tipo');
        $this->createSequence('licitacao.tipo_instrumento_seq', 'licitacao', 'tipo_instrumento', 'cod_tipo');
        $this->changeColumnToDateTimeMicrosecondType(CompraDireta::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CompraDiretaAnulacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(MapaSolicitacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Atividade::class, 'timestamp');
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
