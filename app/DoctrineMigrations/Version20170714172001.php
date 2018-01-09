<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170714172001 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $sql = <<<SQL
CREATE OR REPLACE VIEW pessoal.vw_conceder_ferias AS
 SELECT row_number() OVER () AS cod_ferias,
    concederferias.numcgm,
    concederferias.nom_cgm,
    concederferias.registro,
    concederferias.cod_contrato,
    concederferias.desc_local,
    concederferias.desc_orgao,
    concederferias.orgao,
    concederferias.dt_posse,
    concederferias.dt_admissao,
    concederferias.dt_nomeacao,
    concederferias.desc_funcao,
    concederferias.desc_regime_funcao,
    concederferias.cod_regime_funcao,
    concederferias.cod_funcao,
    concederferias.cod_local,
    concederferias.cod_orgao,
    concederferias.bo_cadastradas,
    concederferias.situacao,
    concederferias.dt_inicial_aquisitivo,
    concederferias.dt_final_aquisitivo,
    concederferias.dt_inicio,
    concederferias.dt_fim,
    concederferias.mes_competencia,
    concederferias.ano_competencia,
        CASE
            WHEN btrim(concederferias.mes_competencia::text) <> ''::text THEN
            CASE
                WHEN btrim(concederferias.mes_competencia::text)::integer > 0 THEN (concederferias.mes_competencia::text || '/'::text) || concederferias.ano_competencia::text
                ELSE NULL::text
            END
            ELSE NULL::text
        END AS competencia,
    to_char(concederferias.dt_inicial_aquisitivo::timestamp with time zone, 'dd/mm/yyyy'::text) AS dt_inicial_aquisitivo_formatado,
    to_char(concederferias.dt_final_aquisitivo::timestamp with time zone, 'dd/mm/yyyy'::text) AS dt_final_aquisitivo_formatado,
    to_char(concederferias.dt_admissao::timestamp with time zone, 'dd/mm/yyyy'::text) AS dt_admissao_formatado,
    sum(COALESCE(ferias.dias_ferias, 0)) + sum(COALESCE(ferias.dias_abono, 0)) AS ferias_tiradas
   FROM concederferias('geral'::character varying, ''::character varying, ( SELECT fpm.cod_periodo_movimentacao
           FROM folhapagamento.periodo_movimentacao fpm,
            folhapagamento.periodo_movimentacao_situacao fpms,
            ( SELECT max(periodo_movimentacao_situacao."timestamp") AS "timestamp"
                   FROM folhapagamento.periodo_movimentacao_situacao
                  WHERE periodo_movimentacao_situacao.situacao = 'a'::bpchar) max_timestamp
          WHERE fpm.cod_periodo_movimentacao = fpms.cod_periodo_movimentacao AND fpms."timestamp" = max_timestamp."timestamp" AND fpms.situacao = 'a'::bpchar), false, ''::character varying, date_part('year'::text, 'now'::text::date)::character varying, 'incluir'::character varying, 0, 0) concederferias(cod_ferias, numcgm, nom_cgm, registro, cod_contrato, desc_local, desc_orgao, orgao, dt_posse, dt_admissao, dt_nomeacao, desc_funcao, desc_regime_funcao, cod_regime_funcao, cod_funcao, cod_local, cod_orgao, bo_cadastradas, situacao, dt_inicial_aquisitivo, dt_final_aquisitivo, dt_inicio, dt_fim, mes_competencia, ano_competencia)
     LEFT JOIN pessoal.ferias ON ferias.dt_inicial_aquisitivo = concederferias.dt_inicial_aquisitivo AND ferias.dt_final_aquisitivo = concederferias.dt_final_aquisitivo AND ferias.cod_contrato = concederferias.cod_contrato
  WHERE (ferias.cod_forma IS NOT NULL AND (ferias.cod_forma <> ALL (ARRAY[1, 2])) AND (ferias.cod_forma = ANY (ARRAY[3, 4])) OR ferias.cod_forma IS NULL) AND recuperarsituacaodocontrato(concederferias.cod_contrato, ( SELECT fpm.cod_periodo_movimentacao
           FROM folhapagamento.periodo_movimentacao fpm,
            folhapagamento.periodo_movimentacao_situacao fpms,
            ( SELECT max(periodo_movimentacao_situacao."timestamp") AS "timestamp"
                   FROM folhapagamento.periodo_movimentacao_situacao
                  WHERE periodo_movimentacao_situacao.situacao = 'a'::bpchar) max_timestamp
          WHERE fpm.cod_periodo_movimentacao = fpms.cod_periodo_movimentacao AND fpms."timestamp" = max_timestamp."timestamp" AND fpms.situacao = 'a'::bpchar), ''::character varying)::text = 'A'::text
  GROUP BY concederferias.cod_ferias, concederferias.numcgm, concederferias.nom_cgm, concederferias.registro, concederferias.cod_contrato, concederferias.desc_local, concederferias.desc_orgao, concederferias.orgao, concederferias.dt_posse, concederferias.dt_admissao, concederferias.dt_nomeacao, concederferias.desc_funcao, concederferias.desc_regime_funcao, concederferias.cod_regime_funcao, concederferias.cod_funcao, concederferias.cod_local, concederferias.cod_orgao, concederferias.bo_cadastradas, concederferias.situacao, concederferias.dt_inicial_aquisitivo, concederferias.dt_final_aquisitivo, concederferias.dt_inicio, concederferias.dt_fim, concederferias.mes_competencia, concederferias.ano_competencia
 HAVING
        CASE
            WHEN 'incluir'::text = 'incluir'::text THEN
            CASE
                WHEN (sum(COALESCE(ferias.dias_ferias, 0)) + sum(COALESCE(ferias.dias_abono, 0))) < 30 THEN true
                ELSE false
            END
            ELSE true
        END
  ORDER BY concederferias.nom_cgm, concederferias.dt_inicial_aquisitivo, concederferias.dt_final_aquisitivo;
SQL;
        $this->addSql($sql);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
