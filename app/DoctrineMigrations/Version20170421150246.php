<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170421150246 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );
        $this->addSql(
            'insert into administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) ' .
            'values (nextval(\'administracao.rota_cod_rota_seq\'), \'patrimonio_manutencao_home\', ' .
            '\'Manutenção Gestão\', \'patrimonial\');'
        );
        $this->addSql(
            'insert into administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) ' .
            'values (nextval(\'administracao.rota_cod_rota_seq\'), ' .
            '\'urbem_patrimonial_patrimonio_manutencao_paga_list\', ' .
            '\'Manutenção Paga\', \'patrimonio_manutencao_home\');'
        );
        $this->addSql(
            'insert into administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) ' .
            'values (nextval(\'administracao.rota_cod_rota_seq\'), ' .
            '\'urbem_patrimonial_patrimonio_manutencao_paga_create\', \'Novo\', ' .
            '\'urbem_patrimonial_patrimonio_manutencao_paga_list\');'
        );
        $this->addSql(
            'insert into administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) ' .
            'values (nextval(\'administracao.rota_cod_rota_seq\'), ' .
            '\'urbem_patrimonial_patrimonio_manutencao_paga_delete\', \'Excluir\', ' .
            '\'urbem_patrimonial_patrimonio_manutencao_paga_list\');'
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );
        $this->addSql(
            'delete from administracao.rota where descricao_rota like \'urbem_patrimonial_patrimonio_manutencao_paga%\''
        );
        $this->addSql('delete from administracao.rota where descricao_rota = \'patrimonio_manutencao_home\'');
    }
}
