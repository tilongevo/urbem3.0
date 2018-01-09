<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171102115316 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Transferencia::class, 'dt_autenticacao');
        $this->addSql("UPDATE administracao.rota set traducao_rota = 'Depósito/Retiradas - Novo', rota_superior = 'tesouraria_outras_operacoes_home' where descricao_rota = 'urbem_financeiro_tesouraria_deposito_create';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
