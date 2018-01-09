<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170530172505 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_condominio_list', 'Condomínio', 'tributario_imobiliario_edificacao_home');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_condominio_create', 'Incluir', 'urbem_tributario_imobiliario_edificacao_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_condominio_edit', 'Editar', 'urbem_tributario_imobiliario_edificacao_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_condominio_delete', 'Excluir', 'urbem_tributario_imobiliario_edificacao_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_condominio_show', 'Detalhe', 'urbem_tributario_imobiliario_edificacao_condominio_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
