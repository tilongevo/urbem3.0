<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170526210027 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_despachar', 'Despachar', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_encaminhar', 'Encaminhar', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_receber', 'Receber', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_arquivar', 'Arquivar', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_cancelar_encaminhamento', 'Cancelar Encaminhamento', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_desarquivar', 'Desarquivar', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_apensar', 'Apensar', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_desapensar', 'Desapensar', 'urbem_administrativo_protocolo_processo_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_etapa_imprimir_etiqueta', 'Imprimir Etiqueta', 'urbem_administrativo_protocolo_processo_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_despachar', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_encaminhar', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_receber', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_arquivar', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_cancelar_encaminhamento', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_desarquivar', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_apensar', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_desapensar', 'urbem_administrativo_protocolo_processo_list');
        $this->removeRoute('urbem_administrativo_protocolo_processo_etapa_imprimir_etiqueta', 'urbem_administrativo_protocolo_processo_list');
    }
}
