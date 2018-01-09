<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170914134638 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('tributario_arrecadacao_calculo_efetuar_lancamentos_home', 'Efetuar Lançamentos', 'tributario_arrecadacao_calculo_home');
        $this->insertRoute('urbem_tributario_arrecadacao_calculo_efetuar_lancamento_manual_create', 'Manual', 'tributario_arrecadacao_calculo_efetuar_lancamentos_home');
        $this->insertRoute('urbem_tributario_arrecadacao_calculo_efetuar_lancamento_manual_show', 'Detalhe', 'tributario_arrecadacao_calculo_efetuar_lancamentos_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
