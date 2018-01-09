<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170418154208 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_list', 'Cadastro Imobiliário - Face de Quadra', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_create', 'Incluir', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_edit', 'Alterar', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_delete', 'Excluir', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_show', 'Detalhe', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_baixar', 'Baixar', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_reativar', 'Reativar', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_caracteristicas', 'Alterar Características', 'urbem_tributario_imobiliario_face_quadra_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
