<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170511134857 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_list', 'Dívida Ativa - Autoridade', 'tributario');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_create', 'Incluir Autoridade', 'urbem_tributario_divida_ativa_autoridade_list');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_edit', 'Alterar Autoridade', 'urbem_tributario_divida_ativa_autoridade_list');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_delete', 'Excluir Autoridade', 'urbem_tributario_divida_ativa_autoridade_list');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_show', 'Autoridade', 'urbem_tributario_divida_ativa_autoridade_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
