<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170327070813 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES(nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_financeiro_contabilidade_configuracao_encerrar_mes_permissao\', \'Permissão\', \'contabilidade_configuracao_home\');');
        $this->removeRoute('urbem_financeiro_contabilidade_configuracao_encerrar_mes_list', 'contabilidade_configuracao_home');
        $this->updateUpperRoute('urbem_financeiro_contabilidade_configuracao_encerrar_mes_create', 'contabilidade_configuracao_home');
        $this->removeRoute('urbem_financeiro_contabilidade_configuracao_reabrir_mes_encerrado_list', 'contabilidade_configuracao_home');
        $this->updateUpperRoute('urbem_financeiro_contabilidade_configuracao_reabrir_mes_encerrado_create', 'contabilidade_configuracao_home');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES(nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_financeiro_contabilidade_configuracao_reabrir_mes_encerrado_permissao\', \'Permissão\', \'contabilidade_configuracao_home\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
