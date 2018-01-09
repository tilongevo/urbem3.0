<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class CedidosAdidosModel
 */
class CedidosAdidosModel extends PeriodoMovimentacaoModel
{
    /**
     * @param string|integer $exercicio
     * @param string         $stEntidade
     * @param string|integer $codPeriodoMovimentacao
     * @param string|integer $codEntidade
     *
     * @return array
     */
    public function getDadosExportacao($exercicio, $stEntidade, $codPeriodoMovimentacao, $codEntidade)
    {
        $dataFinalCompetencia = $this->getDataFinalCompetenciaPeriodoMovimentacao($codPeriodoMovimentacao, $stEntidade);

        $sql = <<<SQL
SELECT
  LPAD(CAST((SELECT cod_entidade
             FROM orcamento.entidade
             WHERE cod_entidade = :cod_entidade
                   AND exercicio = :exercicio :: TEXT) AS TEXT), 2, '0')                                      AS numero_entidade,
  to_char(:data_final_competencia :: DATE, 'mm/yyyy')                                                         AS mes_ano,
  LPAD(CAST(contrato.registro AS TEXT), 8, '0')                                                               AS matricula_servidor,
  RPAD(adidos_cedidos.nom_cgm, 60, ' ')                                                                       AS nom_cgm,
  RPAD(adidos_cedidos.situacao, 40, ' ')                                                                      AS situacao,
  RPAD(adidos_cedidos.ato_cedencia, 10, ' ')                                                                  AS ato_cedencia,
  adidos_cedidos.dt_inicial,
  adidos_cedidos.dt_final,
  RPAD(adidos_cedidos.tipo_cedencia, 10, ' ')                                                                 AS tipo_cedencia,
  RPAD(adidos_cedidos.indicativo_onus, 20, ' ')                                                               AS indicativo_onus,
  RPAD(adidos_cedidos.orgao_cedente_cessionario, 60, ' ')                                                     AS orgao_cedente_cessionario,
  RPAD(adidos_cedidos.num_convenio, 15, ' ')                                                                  AS num_convenio,
  RPAD(adidos_cedidos.local, 60, ' ')                                                                         AS local
FROM pessoal$stEntidade.contrato
  , (
      SELECT
        contrato_servidor.cod_contrato,
        sw_cgm.nom_cgm,
        recuperarSituacaoDoContratoLiteral(contrato_servidor.cod_contrato, :cod_periodo_movimentacao,
                                           '$stEntidade')            AS situacao,
        (SELECT norma.num_norma || '/' || norma.exercicio
         FROM normas.norma
         WHERE norma.cod_norma = adido_cedido.cod_norma)             AS ato_cedencia,
        to_char(adido_cedido.dt_inicial, 'ddmmyyyy')                 AS dt_inicial,
        to_char(adido_cedido.dt_final, 'ddmmyyyy')                   AS dt_final,
        (CASE WHEN adido_cedido.tipo_cedencia = 'a'
          THEN 'Adido'
         ELSE 'Cedido'
         END)                                                        AS tipo_cedencia,
        (CASE WHEN adido_cedido.indicativo_onus = 'c'
          THEN 'Ônus do Cedente'
         ELSE 'Ônus do Cessionário'
         END)                                                        AS indicativo_onus,
        (SELECT nom_cgm
         FROM sw_cgm
         WHERE sw_cgm.numcgm = adido_cedido.cgm_cedente_cessionario) AS orgao_cedente_cessionario,
        adido_cedido.num_convenio,
        adido_cedido_local.descricao_local                           AS LOCAL
      FROM pessoal$stEntidade.contrato_servidor

        INNER JOIN (
                     SELECT adido_cedido.*
                     FROM pessoal$stEntidade.adido_cedido
                       INNER JOIN (
                                    SELECT
                                      adido_cedido.cod_contrato,
                                      max(adido_cedido.timestamp) AS TIMESTAMP
                                    FROM pessoal$stEntidade.adido_cedido
                                    WHERE adido_cedido.timestamp <= (SELECT ultimotimestampperiodomovimentacao(
                                        :cod_periodo_movimentacao, '$stEntidade')) :: TIMESTAMP
                                    GROUP BY adido_cedido.cod_contrato
                                  ) AS max_adido_cedido
                         ON max_adido_cedido.cod_contrato = adido_cedido.cod_contrato
                            AND max_adido_cedido.timestamp = adido_cedido.timestamp
                   ) AS adido_cedido
          ON contrato_servidor.cod_contrato = adido_cedido.cod_contrato
        INNER JOIN pessoal$stEntidade.servidor_contrato_servidor
          ON contrato_servidor.cod_contrato = servidor_contrato_servidor.cod_contrato

        INNER JOIN pessoal$stEntidade.servidor
          ON servidor_contrato_servidor.cod_servidor = servidor.cod_servidor

        INNER JOIN sw_cgm
          ON servidor.numcgm = sw_cgm.numcgm

        LEFT JOIN (
                    SELECT
                      adido_cedido_local.cod_contrato,
                      adido_cedido_local.cod_local,
                      LOCAL.descricao AS descricao_local
                    FROM pessoal$stEntidade.adido_cedido_local
                      INNER JOIN (
                                   SELECT
                                     adido_cedido_local.cod_contrato,
                                     max(adido_cedido_local.timestamp) AS TIMESTAMP
                                   FROM pessoal$stEntidade.adido_cedido_local
                                   WHERE adido_cedido_local.timestamp <= (SELECT ultimotimestampperiodomovimentacao(
                                       :cod_periodo_movimentacao, '$stEntidade')) :: TIMESTAMP
                                   GROUP BY adido_cedido_local.cod_contrato
                                 ) AS max_adido_cedido_local
                        ON max_adido_cedido_local.cod_contrato = adido_cedido_local.cod_contrato
                           AND max_adido_cedido_local.timestamp = adido_cedido_local.timestamp

                      LEFT JOIN organograma.local
                        ON LOCAL.cod_local = adido_cedido_local.cod_local

                  ) AS adido_cedido_local
          ON contrato_servidor.cod_contrato = adido_cedido_local.cod_contrato

    ) AS adidos_cedidos
WHERE contrato.cod_contrato = adidos_cedidos.cod_contrato
ORDER BY nom_cgm, contrato.registro;
SQL;

        return $this->getQueryResults($sql, [
            'data_final_competencia'   => $dataFinalCompetencia,
            'cod_entidade'             => $codEntidade,
            'exercicio'                => $exercicio,
            'cod_periodo_movimentacao' => $codPeriodoMovimentacao,
        ]);
    }
}
