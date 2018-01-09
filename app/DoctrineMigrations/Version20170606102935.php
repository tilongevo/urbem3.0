<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170606102935 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(AtributoConstrucaoOutrosValor::class, 'timestamp');

        $this->insertRoute('tributario_imobiliario_construcao_home', 'Cadastro Imobiliário - Construção', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_construcao_imovel_list', 'Imóvel', 'tributario_imobiliario_construcao_home');
        $this->insertRoute('urbem_tributario_imobiliario_construcao_imovel_create', 'Incluir', 'urbem_tributario_imobiliario_construcao_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_construcao_imovel_edit', 'Alterar', 'urbem_tributario_imobiliario_construcao_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_construcao_imovel_delete', 'Excluir', 'urbem_tributario_imobiliario_construcao_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_construcao_condominio_list', 'Condomínio', 'tributario_imobiliario_construcao_home');
        $this->insertRoute('urbem_tributario_imobiliario_construcao_condominio_create', 'Incluir', 'urbem_tributario_imobiliario_construcao_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_construcao_condominio_edit', 'Alterar', 'urbem_tributario_imobiliario_construcao_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_construcao_condominio_delete', 'Excluir', 'urbem_tributario_imobiliario_construcao_condominio_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
