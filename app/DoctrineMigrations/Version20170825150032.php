<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Arrecadacao\PermissaoCancelamento;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170825150032 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_arrecadacao_definir_permissao_cancelamento_create', 'Incluir', 'urbem_tributario_arrecadacao_definir_permissao_cancelamento_list');
        $this->insertRoute('urbem_tributario_arrecadacao_definir_permissao_cancelamento_delete', 'Excluir', 'urbem_tributario_arrecadacao_definir_permissao_cancelamento_list');
        $this->insertRoute('urbem_tributario_arrecadacao_definir_permissao_cancelamento_list', 'Definir Permissões para Cancelamento', 'tributario_arrecadacao_baixa_debitos_home');
        $this->changeColumnToDateTimeMicrosecondType(PermissaoCancelamento::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
