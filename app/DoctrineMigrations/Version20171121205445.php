<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171121205445 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('compras_governamentais', 'Compras Governamentais', 'home-urbem');
        $this->insertRoute('compras_governamentais_requisicao_index', 'Requisição', 'compras_governamentais');
        $this->insertRoute('urbem_compras_governamentais_requisicao_consultar_item_list', 'Consultar Item', 'compras_governamentais_requisicao_index');

        $this->addSql('ALTER TABLE almoxarifado.requisicao_item ADD quantidade_aprovada numeric(14,4) NOT NULL DEFAULT 0;');
        $this->addSql('ALTER TABLE almoxarifado.requisicao_item ADD quantidade_recusada numeric(14,4) NOT NULL DEFAULT 0;');
        $this->addSql('ALTER TABLE almoxarifado.requisicao_item ADD quantidade_pendente numeric(14,4) NOT NULL DEFAULT 0;');
        $this->addSql('ALTER TABLE almoxarifado.requisicao_item ADD observacao text NULL;');
        $this->addSql('ALTER TABLE almoxarifado.requisicao_item ADD situacao int4 NOT NULL DEFAULT 0;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('compras_governamentais', 'home-urbem');
    }
}
