<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170508125634 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('imobiliario.natureza_transferencia_seq', 'imobiliario', 'natureza_transferencia', 'cod_natureza');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_natureza_transferencia_list\', \'Cadastro Imobiliário - Natureza de Transferência\', \'tributario\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_natureza_transferencia_create\', \'Incluir\', \'urbem_tributario_imobiliario_natureza_transferencia_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_natureza_transferencia_edit\', \'Alterar\', \'urbem_tributario_imobiliario_natureza_transferencia_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_natureza_transferencia_delete\', \'Excluir\', \'urbem_tributario_imobiliario_natureza_transferencia_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_natureza_transferencia_show\', \'Detalhe\', \'urbem_tributario_imobiliario_natureza_transferencia_list\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
