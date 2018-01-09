<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180104102157 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'patrimonio_compras_relatorios_home', 'Compras - Relatórios', 'patrimonial');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_patrimonial_compras_relatorios_compra_estoque_list', 'Compras e Estoque', 'patrimonio_compras_relatorios_home');");

        $this->addSql("ALTER TABLE almoxarifado.lancamento_material ADD COLUMN timestamp TIMESTAMP WITHOUT TIME ZONE;");

        $this->addSql("UPDATE almoxarifado.lancamento_material SET timestamp = CONCAT(COALESCE(exercicio_lancamento, EXTRACT(YEAR FROM NOW())::text), '-01-01')::timestamp;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("ALTER TABLE almoxarifado.lancamento_material DROP COLUMN timestamp;");
    }
}
