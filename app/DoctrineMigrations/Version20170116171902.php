<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos;
use Urbem\CoreBundle\Entity\Licitacao\Documento;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para mudar a coluna Timestamp das tabelas Licitacao.Documento, Licitacao.ParticipanteDocumentos,
 * Licitacao.CertificacaoDocumentos para DateTimeMicrosecondPk
 */
class Version20170116171902 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Documento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ParticipanteDocumentos::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CertificacaoDocumentos::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
