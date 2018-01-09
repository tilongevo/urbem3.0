<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170417141224 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('monetario.moeda_seq', 'monetario', 'moeda', 'cod_moeda');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_monetario_moeda_list\', \'Cadastro Monetário - Moeda\', \'tributario\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_monetario_moeda_create\', \'Incluir\', \'urbem_tributario_monetario_moeda_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_monetario_moeda_edit\', \'Alterar\', \'urbem_tributario_monetario_moeda_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_monetario_moeda_delete\', \'Excluir\', \'urbem_tributario_monetario_moeda_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_monetario_moeda_show\', \'Detalhe\', \'urbem_tributario_monetario_moeda_list\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
