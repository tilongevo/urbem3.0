<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170825185343 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('tributario_divida_ativa_cobranca_administrativa_home', 'Dívida Ativa - Cobrança Administrativa', 'tributario');
        $this->insertRoute('urbem_tributario_divida_ativa_cobranca_administrativa_estornar_cobranca_list', 'Estornar Cobrança', 'tributario_divida_ativa_cobranca_administrativa_home');
        $this->insertRoute('urbem_tributario_divida_ativa_cobranca_administrativa_estornar_cobranca_batch', 'Estornar Cobrança', 'tributario_divida_ativa_cobranca_administrativa_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
