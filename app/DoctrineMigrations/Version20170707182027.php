<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170707182027 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_estagio_curso_instituicao_ensino_create', 'Cursos/Área de Conhecimento - Incluir', 'urbem_recursos_humanos_estagio_instituicao_ensino_list');
        $this->insertRoute('urbem_recursos_humanos_estagio_curso_instituicao_ensino_edit', 'Cursos/Área de Conhecimento - Alterar', 'urbem_recursos_humanos_estagio_instituicao_ensino_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_estagio_curso_instituicao_ensino_create', 'Cursos/Área de Conhecimento - Incluir', 'urbem_recursos_humanos_estagio_instituicao_ensino_list');
        $this->insertRoute('urbem_recursos_humanos_estagio_curso_instituicao_ensino_edit', 'Cursos/Área de Conhecimento - Alterar', 'urbem_recursos_humanos_estagio_instituicao_ensino_list');
    }
}
