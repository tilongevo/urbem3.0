<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170519152523 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('imobiliario.transferencia_imovel_seq', 'imobiliario', 'transferencia_imovel', 'cod_transferencia');
        $this->changeColumnToDateTimeMicrosecondType(TransferenciaImovel::class, 'dt_cadastro');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_imobiliario_transferencia_propriedade_list', 'Cadastro Imobiliário - Transferência de Propriedade', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_imobiliario_transferencia_propriedade_create', 'Incluir', 'urbem_tributario_imobiliario_transferencia_propriedade_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_imobiliario_transferencia_propriedade_edit', 'Alterar', 'urbem_tributario_imobiliario_transferencia_propriedade_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_imobiliario_transferencia_propriedade_delete', 'Excluir', 'urbem_tributario_imobiliario_transferencia_propriedade_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_imobiliario_transferencia_propriedade_show', 'Detalhe', 'urbem_tributario_imobiliario_transferencia_propriedade_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
