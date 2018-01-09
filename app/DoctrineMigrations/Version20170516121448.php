<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil;
use Urbem\CoreBundle\Entity\Economico\DomicilioFiscal;
use Urbem\CoreBundle\Entity\Economico\DomicilioInformado;
use Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170516121448 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->createSequence('economico.cadastro_economico_seq', 'economico', 'cadastro_economico', 'inscricao_economica');
        $this->changeColumnToDateTimeMicrosecondType(CadastroEconomico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(DomicilioFiscal::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ProcessoCadastroEconomico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoEmpresaFatoValor::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(DomicilioInformado::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CadastroEconRespContabil::class, 'timestamp');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'tributario_economico_cadastro_economico_home', 'Cadastro Econômico - Inscrição Econômica', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_empresa_fato_list', 'Empresa de Fato', 'tributario_economico_cadastro_economico_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_empresa_fato_create', 'Incluir', 'urbem_tributario_economico_cadastro_economico_empresa_fato_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_empresa_fato_edit', 'Alterar', 'urbem_tributario_economico_cadastro_economico_empresa_fato_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_empresa_fato_delete', 'Excluir', 'urbem_tributario_economico_cadastro_economico_empresa_fato_list');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_cadastro_economico_empresa_fato_show', 'Detalhe', 'urbem_tributario_economico_cadastro_economico_empresa_fato_list');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
