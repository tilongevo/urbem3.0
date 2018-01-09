<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170331171530 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('imobiliario.vigencia_seq', 'imobiliario', 'vigencia', 'cod_vigencia');
        $this->insertRoute('tributario_imobiliario_hierarquia_home', 'Cadastro Imobiliário - Hierarquia', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_vigencia_list', 'Vigência', 'tributario_imobiliario_hierarquia_home');
        $this->insertRoute('urbem_tributario_imobiliario_vigencia_create', 'Incluir', 'urbem_tributario_imobiliario_vigencia_list');
        $this->insertRoute('urbem_tributario_imobiliario_vigencia_edit', 'Alterar', 'urbem_tributario_imobiliario_vigencia_list');
        $this->insertRoute('urbem_tributario_imobiliario_vigencia_delete', 'Excluir', 'urbem_tributario_imobiliario_vigencia_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
