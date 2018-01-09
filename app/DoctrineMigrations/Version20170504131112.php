<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Economico\AliquotaAtividade;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Entity\Economico\NivelAtividade;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170504131112 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->createSequence('economico.atividade_seq', 'economico', 'atividade', 'cod_atividade');
        $this->changeColumnToDateTimeMicrosecondType(AliquotaAtividade::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Atividade::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(NivelAtividade::class, 'timestamp');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_atividade_economica_list', 'Cadastro Econômico - Atividade Econômica', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_atividade_economica_create', 'Incluir', 'urbem_tributario_economico_atividade_economica_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_atividade_economica_edit', 'Alterar', 'urbem_tributario_economico_atividade_economica_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_atividade_economica_delete', 'Excluir', 'urbem_tributario_economico_atividade_economica_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_atividade_economica_show', 'Detalhe', 'urbem_tributario_economico_atividade_economica_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
