<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170512183425 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'tributario_imobiliario_corretagem_filtro', 'Cadastro Imobiliário - Corretagem', 'tributario');");
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_corretor_list\', \'Cadastro Imobiliário - Corretor\', \'tributario\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_corretor_create\', \'Incluir\', \'urbem_tributario_imobiliario_corretor_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_corretor_edit\', \'Alterar\', \'urbem_tributario_imobiliario_corretor_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_corretor_delete\', \'Excluir\', \'urbem_tributario_imobiliario_corretor_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_corretor_show\', \'Detalhe\', \'urbem_tributario_imobiliario_corretor_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_imobiliaria_list\', \'Cadastro Imobiliário - Imobiliária\', \'tributario\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_imobiliaria_create\', \'Incluir\', \'urbem_tributario_imobiliario_imobiliaria_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_imobiliaria_edit\', \'Alterar\', \'urbem_tributario_imobiliario_imobiliaria_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_imobiliaria_delete\', \'Excluir\', \'urbem_tributario_imobiliario_imobiliaria_list\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_tributario_imobiliario_imobiliaria_show\', \'Detalhe\', \'urbem_tributario_imobiliario_imobiliaria_list\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
