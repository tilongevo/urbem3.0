<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Compras\Ordem;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170104134715 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Ordem::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CompraDireta::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Solicitacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(SolicitacaoHomologada::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(SolicitacaoHomologadaAnulacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(SolicitacaoAnulacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CatalogoItem::class, 'timestamp_inclusao');
        $this->changeColumnToDateTimeMicrosecondType(CatalogoItem::class, 'timestamp_alteracao');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
