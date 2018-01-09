<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon;
use Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170531174012 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->changeColumnToDateTimeMicrosecondType(DiasCadastroEconomico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ProcessoAtividadeCadEcon::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ProcessoDiasCadEcon::class, 'timestamp');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_atividade_cadastro_economico_definir', 'Definir Atividades', 'tributario_economico_cadastro_economico_home');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
