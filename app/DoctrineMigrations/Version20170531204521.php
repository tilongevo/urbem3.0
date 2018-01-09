<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170531204521 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_etiqueta', 'Imprimir Etiqueta', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_etiquetas', 'Imprimir Etiquetas', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_despacho', 'Imprimir Despachos', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_recibo', 'Imprimir Recibo de Processo', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_recibo_entrega', 'Imprimir Recibo de Entrega de Processos', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_arquivamento_temporario', 'Imprimir Arquivamento de Processo Temporário', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_arquivamento_definitivo', 'Imprimir Arquivamento de Processo Definitivo', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_salvar', 'Imprimir Relatório de Processo', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_relatorio_relatorio_volume', 'Imprimir Relatório de Volume de Processos', 'urbem_administrativo_protocolo_processo_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_etiqueta', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_etiquetas', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_despacho', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_recibo', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_recibo_entrega', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_arquivamento_temporario', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_arquivamento_definitivo', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_salvar', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_relatorio_relatorio_volume', 'urbem_administrativo_protocolo_processo_list');
    }
}
