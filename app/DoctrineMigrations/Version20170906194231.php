<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170906194231 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("
            CREATE OR REPLACE VIEW pessoal.vw_consultar_cancelar_ferias AS
             SELECT concederferias.cod_ferias,
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
                case
                    when btrim(
                        concederferias.mes_competencia::text
                    )<> ''::text then case
                        when btrim(
                            concederferias.mes_competencia::text
                        )::integer > 0 then(
                            concederferias.mes_competencia::text || '/'::text
                        )|| concederferias.ano_competencia::text
                        else null::text
                    end
                    else null::text
                end as competencia,
                to_char(
                    concederferias.dt_inicial_aquisitivo::timestamp with time zone,
                    'dd/mm/yyyy'::text
                ) as dt_inicial_aquisitivo_formatado,
                to_char(
                    concederferias.dt_final_aquisitivo::timestamp with time zone,
                    'dd/mm/yyyy'::text
                ) as dt_final_aquisitivo_formatado,
                to_char(
                    concederferias.dt_admissao::timestamp with time zone,
                    'dd/mm/yyyy'::text
                ) as dt_admissao_formatado,
                sum( coalesce( ferias.dias_ferias, 0 ))+ sum( coalesce( ferias.dias_abono, 0 )) as ferias_tiradas
            from
                concederferias(
                    'geral'::character varying,
                    ''::character varying,
                    (
                        select
                            fpm.cod_periodo_movimentacao
                        from
                            folhapagamento.periodo_movimentacao fpm,
                            folhapagamento.periodo_movimentacao_situacao fpms,
                            (
                                select
                                    max( periodo_movimentacao_situacao.\"timestamp\" ) as \"timestamp\"
                                from
                                    folhapagamento.periodo_movimentacao_situacao
                                where
                                    periodo_movimentacao_situacao.situacao = 'a'::bpchar
                            ) max_timestamp
                        where
                            fpm.cod_periodo_movimentacao = fpms.cod_periodo_movimentacao
                            and fpms.\"timestamp\" = max_timestamp.\"timestamp\"
                            and fpms.situacao = 'a'::bpchar
                    ),
                    false,
                    ''::character varying,
                    date_part(
                        'year'::text,
                        'now'::text::date
                    )::character varying,
                    'consultar'::character varying,
                    0,
                    0
                ) concederferias(
                    cod_ferias,
                    numcgm,
                    nom_cgm,
                    registro,
                    cod_contrato,
                    desc_local,
                    desc_orgao,
                    orgao,
                    dt_posse,
                    dt_admissao,
                    dt_nomeacao,
                    desc_funcao,
                    desc_regime_funcao,
                    cod_regime_funcao,
                    cod_funcao,
                    cod_local,
                    cod_orgao,
                    bo_cadastradas,
                    situacao,
                    dt_inicial_aquisitivo,
                    dt_final_aquisitivo,
                    dt_inicio,
                    dt_fim,
                    mes_competencia,
                    ano_competencia
                ) left join pessoal.ferias on
                ferias.dt_inicial_aquisitivo = concederferias.dt_inicial_aquisitivo
                and ferias.dt_final_aquisitivo = concederferias.dt_final_aquisitivo
                and ferias.cod_contrato = concederferias.cod_contrato
            where
                (
                    (
                        ferias.cod_forma is not null
                    )
                    or ferias.cod_forma is null
                )
            group by
                concederferias.cod_ferias,
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
                concederferias.ano_competencia
            having
                case
                    when 'consultar'::text = 'incluir'::text then case
                        when(
                            sum( coalesce( ferias.dias_ferias, 0 ))+ sum( coalesce( ferias.dias_abono, 0 ))
                        )< 30 then true
                        else false
                    end
                    else true
                end
            order by
                concederferias.nom_cgm,
                concederferias.dt_inicial_aquisitivo,
                concederferias.dt_final_aquisitivo;
        ");
        $this->insertRoute('urbem_recursos_humanos_pessoal_ferias_consultar_list', 'Férias', 'pessoal_ferias_home');
        $this->insertRoute('urbem_recursos_humanos_pessoal_ferias_consultar_show', 'Consultar', 'urbem_recursos_humanos_pessoal_ferias_consultar_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->removeRoute('urbem_recursos_humanos_pessoal_ferias_consultar_list', 'pessoal_ferias_home');
        $this->removeRoute('urbem_recursos_humanos_pessoal_ferias_consultar_create', 'urbem_recursos_humanos_pessoal_ferias_consultar_list');
    }
}
