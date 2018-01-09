<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170419142604 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_especialidade_create', 'Especialidade - Novo', 'urbem_recursos_humanos_pessoal_cargo_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_especialidade_edit', 'Especialidade - Editar', 'urbem_recursos_humanos_pessoal_cargo_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_especialidade_delete', 'Especialidade - Apagar', 'urbem_recursos_humanos_pessoal_cargo_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_padrao_create', 'Cargo Padrão - Novo', 'urbem_recursos_humanos_pessoal_cargo_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_padrao_edit', 'Cargo Padrão - Editar', 'urbem_recursos_humanos_pessoal_cargo_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_padrao_delete', 'Cargo Padrão - Apagar', 'urbem_recursos_humanos_pessoal_cargo_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
