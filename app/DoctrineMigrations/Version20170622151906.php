<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\Licenca;
use Urbem\CoreBundle\Entity\Imobiliario\Permissao;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170622151906 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Licenca::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Permissao::class, 'timestamp');
        $this->insertRoute('tributario_imobiliario_licencas_home', 'Cadastro Imobiliário - Licenças', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_permissao_list', 'Definir Permissão para Concessão de Licenças', 'tributario_imobiliario_licencas_home');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_permissao_create', 'Incluir Permissão', 'urbem_tributario_imobiliario_licencas_permissao_list');
        $this->insertRoute('urbem_tributario_imobiliario_licencas_permissao_delete', 'Excluir Permissão', 'urbem_tributario_imobiliario_licencas_permissao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
