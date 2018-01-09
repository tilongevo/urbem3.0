<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170411180446 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP SEQUENCE IF EXISTS economico.seq_economio_cod_vigencia;");
        $this->addSql("CREATE SEQUENCE economico.seq_economio_cod_vigencia START 1;");
        $this->addSql("SELECT SETVAL('economico.seq_economio_cod_vigencia', (SELECT MAX(cod_vigencia) + 1 FROM economico.vigencia_servico), FALSE);");
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_list', 'Cadastro Econômico - Vigência', 'tributario');
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_create', 'Incluir', 'urbem_tributario_economico_vigencia_servico_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_show', 'Detalhe', 'urbem_tributario_economico_vigencia_servico_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_edit', 'Alterar', 'urbem_tributario_economico_vigencia_servico_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_delete', 'Excluir', 'urbem_tributario_economico_vigencia_servico_list');
        $this->insertRoute('tributario_economico_hierarquia_servico_home', 'Cadastro Econômico - Hierarquia de Serviço', 'tributario');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
