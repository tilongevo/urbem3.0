<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170515151202 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_administrativo_logradouro_historico_create', 'Adicionar Histórico', 'urbem_administrativo_logradouro_list');
        $this->insertRoute('urbem_administrativo_logradouro_historico_edit', 'Editar Histórico', 'urbem_administrativo_logradouro_list');

        /**
         * Removendo e Adicionando novamente essa rota por causa, porque o nome dela estava fora do padrão do sistema.
         */
        $this->removeRoute('urbem_administrativo_logradouro_create', 'urbem_administrativo_logradouro_list');
        $this->insertRoute('urbem_administrativo_logradouro_create', 'Novo', 'urbem_administrativo_logradouro_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_administrativo_logradouro_historico_create', 'urbem_administrativo_logradouro_list');
        $this->removeRoute('urbem_administrativo_logradouro_historico_edit', 'urbem_administrativo_logradouro_list');

        $this->insertRoute('urbem_administrativo_logradouro_create', 'Logradouro - Novo', 'urbem_administrativo_logradouro_list');
    }
}
