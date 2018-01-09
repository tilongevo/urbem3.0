<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170124165301 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.exercicio_id_iventario_idx');
        $this->addSql('CREATE INDEX exercicio_id_iventario_idx ON patrimonio.inventario_historico_bem USING btree (exercicio, id_inventario)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.cod_bem_idx');
        $this->addSql('CREATE INDEX cod_bem_idx ON patrimonio.inventario_historico_bem USING btree (cod_bem)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.cod_bem_timestamp_historico_idx');
        $this->addSql('CREATE INDEX cod_bem_timestamp_historico_idx ON patrimonio.inventario_historico_bem USING btree (cod_bem, timestamp_historico)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.cod_situacao_idx');
        $this->addSql('CREATE INDEX cod_situacao_idx ON patrimonio.inventario_historico_bem USING btree (cod_situacao)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.cod_local_idx');
        $this->addSql('CREATE INDEX cod_local_idx ON patrimonio.inventario_historico_bem USING btree (cod_local)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.cod_orgao_idx');
        $this->addSql('CREATE INDEX cod_orgao_idx ON patrimonio.inventario_historico_bem USING btree (cod_orgao)');
        $this->addSql('DROP INDEX IF EXISTS organograma.num_cgm_pf_idx');
        $this->addSql('CREATE INDEX num_cgm_pf_idx ON organograma.orgao USING btree (num_cgm_pf)');
        $this->addSql('DROP INDEX IF EXISTS organograma.cod_calendar_idx');
        $this->addSql('CREATE INDEX cod_calendar_idx ON organograma.orgao USING btree (cod_calendar)');
        $this->addSql('DROP INDEX IF EXISTS organograma.cod_norma_idx');
        $this->addSql('CREATE INDEX cod_norma_idx ON organograma.orgao USING btree (cod_norma)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.historico_bem_cod_bem_idx');
        $this->addSql('CREATE INDEX historico_bem_cod_bem_idx ON patrimonio.historico_bem USING btree (cod_bem)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.historico_bem_cod_situacao_idx');
        $this->addSql('CREATE INDEX historico_bem_cod_situacao_idx ON patrimonio.historico_bem USING btree (cod_situacao)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.historico_bem_cod_local_idx');
        $this->addSql('CREATE INDEX historico_bem_cod_local_idx ON patrimonio.historico_bem USING btree (cod_local)');
        $this->addSql('DROP INDEX IF EXISTS patrimonio.historico_bem_cod_orgao_idx');
        $this->addSql('CREATE INDEX historico_bem_cod_orgao_idx ON patrimonio.historico_bem USING btree (cod_orgao)');
        $this->addSql('DROP INDEX IF EXISTS organograma.orgao_nivel_cod_orgao_idx');
        $this->addSql('CREATE INDEX orgao_nivel_cod_orgao_idx ON organograma.orgao_nivel USING btree (cod_orgao)');
        $this->addSql('DROP INDEX IF EXISTS organograma.orgao_nivel_cod_nivel_cod_organograma_idx');
        $this->addSql('CREATE INDEX orgao_nivel_cod_nivel_cod_organograma_idx ON organograma.orgao_nivel USING btree (cod_nivel,cod_organograma)');
        $this->addSql('DROP INDEX IF EXISTS organograma.organograma_cod_norma_idx');
        $this->addSql('CREATE INDEX organograma_cod_norma_idx ON organograma.organograma USING btree (cod_norma)');
        $this->addSql('DROP INDEX IF EXISTS organograma.organograma_nivel_cod_organograma_idx');
        $this->addSql('CREATE INDEX organograma_nivel_cod_organograma_idx ON organograma.nivel USING btree (cod_organograma)');
        $this->addSql('DROP INDEX IF EXISTS organograma.organograma_orgao_descricao_cod_orgao_idx');
        $this->addSql('CREATE INDEX organograma_orgao_descricao_cod_orgao_idx ON organograma.orgao_descricao USING btree (cod_orgao)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP INDEX IF EXISTS exercicio_id_iventario_idx');
        $this->addSql('DROP INDEX IF EXISTS cod_bem_idx');
        $this->addSql('DROP INDEX IF EXISTS cod_bem_timestamp_historico_idx');
        $this->addSql('DROP INDEX IF EXISTS cod_situacao_idx');
        $this->addSql('DROP INDEX IF EXISTS cod_local_idx');
        $this->addSql('DROP INDEX IF EXISTS cod_orgao_idx');
        $this->addSql('DROP INDEX IF EXISTS num_cgm_pf_idx');
        $this->addSql('DROP INDEX IF EXISTS cod_calendar_idx');
        $this->addSql('DROP INDEX IF EXISTS cod_norma_idx');
        $this->addSql('DROP INDEX IF EXISTS historico_bem_cod_bem_idx');
        $this->addSql('DROP INDEX IF EXISTS historico_bem_cod_situacao_idx');
        $this->addSql('DROP INDEX IF EXISTS historico_bem_cod_local_idx');
        $this->addSql('DROP INDEX IF EXISTS historico_bem_cod_orgao_idx');
        $this->addSql('DROP INDEX IF EXISTS orgao_nivel_cod_orgao_idx');
        $this->addSql('DROP INDEX IF EXISTS orgao_nivel_cod_nivel_cod_organograma_idx');
        $this->addSql('DROP INDEX IF EXISTS organograma_cod_norma_idx');
        $this->addSql('DROP INDEX IF EXISTS organograma_nivel_cod_organograma_idx');
        $this->addSql('DROP INDEX IF EXISTS organograma_orgao_descricao_cod_orgao_idx');
    }
}
