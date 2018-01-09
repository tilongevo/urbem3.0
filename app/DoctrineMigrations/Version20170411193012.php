<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170411193012 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $sql = <<<SQL
CREATE OR REPLACE VIEW patrimonio.vw_bem_patrimonio_orgao AS
 SELECT DISTINCT orgao_nivel.cod_estrutural,
    orgao.cod_orgao,
    orgao.inativacao,
    orgao_nivel.cod_organograma
   FROM organograma.orgao
     JOIN ( SELECT orgao_nivel_1.cod_orgao,
            orgao_nivel_1.cod_nivel,
            orgao_nivel_1.cod_organograma,
            orgao_nivel_1.valor,
            organograma.fn_consulta_orgao(orgao_nivel_1.cod_organograma, orgao_nivel_1.cod_orgao) AS cod_estrutural
           FROM organograma.orgao_nivel orgao_nivel_1) orgao_nivel ON orgao_nivel.cod_orgao = orgao.cod_orgao AND orgao_nivel.cod_nivel = publico.fn_nivel(orgao_nivel.cod_estrutural)
     JOIN ( SELECT max(historico_bem_1."timestamp") AS max,
            historico_bem_1.cod_orgao,
            historico_bem_1.cod_bem
           FROM patrimonio.historico_bem historico_bem_1
          GROUP BY historico_bem_1.cod_orgao, historico_bem_1.cod_bem) historico_bem ON historico_bem.cod_orgao = orgao.cod_orgao
     LEFT JOIN patrimonio.inventario_historico_bem ON inventario_historico_bem.cod_bem = historico_bem.cod_bem
  ORDER BY orgao_nivel.cod_estrutural;
SQL;


        $this->addSql($sql);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql("DROP VIEW IF EXISTS patrimonio.vw_bem_patrimonio_orgao;");
    }
}
