<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170214150746 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("update administracao.configuracao set cod_modulo = 43 where parametro in ('pao_posicao_digito_id', 'pao_digitos_id_projeto', 'pao_digitos_id_atividade', 'pao_digitos_id_oper_especiais', 'pao_digitos_id_nao_orcamentarios');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_financeiro_ppa_configuracao', 'PPA - Configuração', 'ppa_configuracao_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'ppa_configuracao_home', 'PPA - Configuração', 'financeiro');");

        $this->updateUpperRoute('urbem_financeiro_plano_plurianual_ppa_list', 'ppa_configuracao_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("update administracao.configuracao set cod_modulo = 8 where parametro in ('pao_posicao_digito_id', 'pao_digitos_id_projeto', 'pao_digitos_id_atividade', 'pao_digitos_id_oper_especiais', 'pao_digitos_id_nao_orcamentarios');");
    }
}
