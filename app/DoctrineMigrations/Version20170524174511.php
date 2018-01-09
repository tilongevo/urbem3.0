<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\BaixaEmissao;
use Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170524174511 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->changeColumnToDateTimeMicrosecondType(BaixaCadastroEconomico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ProcessoBaixaCadEconomico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BaixaEmissao::class, 'timestamp');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_economico_baixa_cadastro_economico_create', 'Baixar', 'tributario_economico_cadastro_economico_home');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
