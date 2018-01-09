<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Compras\Cotacao;
use Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem;
use Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItemDesclassificacao;
use Urbem\CoreBundle\Entity\Compras\Julgamento;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170203174750 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Cotacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CotacaoFornecedorItem::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CotacaoFornecedorItemDesclassificacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Julgamento::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Cotacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CotacaoFornecedorItem::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CotacaoFornecedorItemDesclassificacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Julgamento::class, 'timestamp');
    }
}
