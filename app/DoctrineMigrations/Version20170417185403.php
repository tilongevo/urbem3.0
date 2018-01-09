<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Economico\NivelServico;
use Urbem\CoreBundle\Entity\Economico\VigenciaServico;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170417185403 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(NivelServico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(VigenciaServico::class, 'timestamp');
        $this->createSequence('economico.nivel_seq', 'economico', 'nivel_servico', 'cod_nivel');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_nivel_servico_filtro', 'Cadastro Econômico - Nível', 'tributario_economico_hierarquia_servico_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_nivel_servico_list', 'Nível', 'urbem_tributario_economico_nivel_servico_filtro');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_nivel_servico_create', 'Incluir', 'urbem_tributario_economico_nivel_servico_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_nivel_servico_edit', 'Alterar', 'urbem_tributario_economico_nivel_servico_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_nivel_servico_delete', 'Excluir', 'urbem_tributario_economico_nivel_servico_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_nivel_servico_show', 'Detalhe', 'urbem_tributario_economico_nivel_servico_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
