<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170310112625 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_financeiro_empenho_empenho_contrato_list\', \'Vincular Empenho a um Contrato\', \'financeiro_empenho_home\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_financeiro_empenho_empenho_contrato_edit\', \'Criar Vínculo\', \'urbem_financeiro_empenho_empenho_contrato_list\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
