<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170615161956 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_imobiliario_loteamento_list', 'Cadastro Imobiliário - Loteamento', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_loteamento_create', 'Incluir', 'urbem_tributario_imobiliario_loteamento_list');
        $this->insertRoute('urbem_tributario_imobiliario_loteamento_edit', 'Editar', 'urbem_tributario_imobiliario_loteamento_list');
        $this->insertRoute('urbem_tributario_imobiliario_loteamento_delete', 'Excluir', 'urbem_tributario_imobiliario_loteamento_list');
        $this->insertRoute('urbem_tributario_imobiliario_loteamento_show', 'Detalhe', 'urbem_tributario_imobiliario_loteamento_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
