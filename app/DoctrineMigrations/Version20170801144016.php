<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170801144016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("update sw_cgm_pessoa_fisica set dt_validade_cnh = now() where dt_validade_cnh = '0001-01-01 BC'");
        $this->addSql("update sw_cgm_pessoa_fisica set dt_validade_cnh = now() where dt_validade_cnh = '0001-01-01'");
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_sefip_create', 'Configuração - SEFIP', 'informacoes_configuracao_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("update sw_cgm_pessoa_fisica set dt_validade_cnh = now() where dt_validade_cnh = '0001-01-01 BC'");
        $this->addSql("update sw_cgm_pessoa_fisica set dt_validade_cnh = now() where dt_validade_cnh = '0001-01-01'");
        $this->insertRoute('urbem_recursos_humanos_ima_configuracao_sefip_create', 'Configuração - SEFIP', 'informacoes_configuracao_home');
    }
}
