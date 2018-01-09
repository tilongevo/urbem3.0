<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170703164032 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_portalservicos_usuario_show', 'Suas Informações', 'home-portalservicos');
        $this->insertRoute('urbem_portalservicos_usuario_edit', 'Editar', 'urbem_portalservicos_usuario_show');
        $this->insertRoute('urbem_portalservicos_usuario_change_password', 'Alterar Senha', 'urbem_portalservicos_usuario_show');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_portalservicos_usuario_show', 'home-portalservicos');
        $this->removeRoute('urbem_portalservicos_usuario_edit', 'urbem_portalservicos_usuario_show');
        $this->removeRoute('urbem_portalservicos_usuario_change_password', 'urbem_portalservicos_usuario_show');
    }
}
