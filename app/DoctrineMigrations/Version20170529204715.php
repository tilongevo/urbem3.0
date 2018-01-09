<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170529204715 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('pessoal.cod_dependente_seq', 'pessoal', 'dependente', 'cod_dependente');
        $this->removeRoute('urbem_recursos_humanos_pessoal_servidor_dependente_create');
        $this->removeRoute('urbem_recursos_humanos_pessoal_servidor_dependente_edit');
        $this->removeRoute('urbem_recursos_humanos_pessoal_servidor_dependente_delete');
        $this->removeRoute('urbem_recursos_humanos_pessoal_servidor_dependente_list');
        $this->removeRoute('urbem_recursos_humanos_pessoal_servidor_dependente_show');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_create', 'Dependente - Novo', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_edit', 'Dependente - Editar', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_delete', 'Dependente - Remover', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_carteira_vacinacao_create', 'Dependente - Carteira de Vacinação - Novo', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_carteira_vacinacao_edit', 'Dependente - Carteira de Vacinação - Editar', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_carteira_vacinacao_delete', 'Dependente - Carteira de Vacinação - Remover', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_comprovante_matricula_create', 'Dependente - Comprovante de Matrícula - Novo', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_comprovante_matricula_edit', 'Dependente - Comprovante de Matrícula - Editar', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_dependente_comprovante_matricula_delete', 'Dependente - Comprovante de Matrícula - Remover', 'urbem_recursos_humanos_pessoal_servidor_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeSequence('pessoal.cod_dependente_seq', 'pessoal', 'dependente', 'cod_dependente');
    }
}
