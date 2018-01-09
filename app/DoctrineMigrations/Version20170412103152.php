<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\SwNomeLogradouro;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170412103152 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(SwNomeLogradouro::class, 'timestamp');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_list', 'Cadastro Imobiliário - Trecho', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_create', 'Incluir', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_edit', 'Alterar', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_delete', 'Excluir', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_show', 'Detalhe', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_baixar', 'Baixar', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_reativar', 'Reativar', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_caracteristicas', 'Alterar Características', 'urbem_tributario_imobiliario_trecho_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
