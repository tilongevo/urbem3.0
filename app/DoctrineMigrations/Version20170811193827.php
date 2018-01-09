<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170811193827 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (in_array($this->container->getParameter("kernel.environment"), ['dev', 'test'])) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
            $this->addSql("delete from folhapagamento.complementar_situacao where cod_complementar > 19 and cod_periodo_movimentacao = 566;");
            $this->addSql("delete from folhapagamento.complementar where cod_periodo_movimentacao = 566 and cod_complementar > 19;");
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if (in_array($this->container->getParameter("kernel.environment"), ['dev', 'test'])) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
            $this->addSql("delete from folhapagamento.complementar_situacao where cod_complementar > 19 and cod_periodo_movimentacao = 566;");
            $this->addSql("delete from folhapagamento.complementar where cod_periodo_movimentacao = 566 and cod_complementar > 19;");
        }
    }
}
