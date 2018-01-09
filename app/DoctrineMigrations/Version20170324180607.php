<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170324180607 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_patrimonial_licitacao_documento_list');
        $this->removeRoute('urbem_patrimonial_licitacao_documentos_list');
        $this->removeRoute('urbem_patrimonial_licitacao_participante_documentos_list');
        $this->removeRoute('urbem_patrimonial_licitacao_licitacao_list');
        $this->removeRoute('urbem_patrimonial_licitacao_membro_adicional_list');
        $this->removeRoute('urbem_patrimonial_licitacao_participante_list');
        $this->insertRoute('urbem_patrimonial_licitacao_documento_list', 'Licitação - Documentos Exigidos', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_documentos_list', 'Licitação - Documentos da Licitação', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_list', 'Licitação - Paricipantes', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_documentos_list', 'Licitação - Participantes Documentos', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_licitacao_list', 'Licitação - Processo Licitatório', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_membro_adicional_list', 'Licitação - Membro Adicional', 'patrimonial');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
