<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170213204459 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('pessoal.cod_assentamento_seq', 'pessoal', 'assentamento_assentamento', 'cod_assentamento');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_edit', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_show', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_delete', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_afastamento_temporario_create', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_afastamento_temporario_edit', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_afastamento_vantagem_create', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_afastamento_vantagem_edit', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_afastamento_permanente_create', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->updateUpperRoute('urbem_recursos_humanos_assentamento_configuracao_afastamento_permanente_edit', 'urbem_recursos_humanos_assentamento_configuracao_list');
        $this->addSql('
        ALTER TABLE pessoal.assentamento_causa_rescisao ALTER COLUMN "timestamp" TYPE timestamp
        USING "timestamp"::timestamp;
        ');
        $this->addSql("
        UPDATE
            organograma.orgao_descricao
        SET
            timestamp = timestamp + interval '543210 microsecond';
        ");
        $this->addSql("
        INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_recursos_humanos_assentamento_configuracao_delete', 'Removar', 'urbem_recursos_humanos_assentamento_configuracao_list');
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->dropSequence('pessoal.cod_assentamento_seq', 'pessoal', 'assentamento_assentamento', 'cod_assentamento');
    }
}
