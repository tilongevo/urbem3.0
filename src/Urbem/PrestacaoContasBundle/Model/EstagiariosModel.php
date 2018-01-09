<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class EstagiariosModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class EstagiariosModel extends PeriodoMovimentacaoModel
{
    /**
     * @param string|integer $codEntidade
     * @param string|integer $exercicio
     * @param string|integer $codPeriodoMovimentacao
     * @param string|integer $stEntidade
     *
     * @return array
     */
    public function getDadosExportacao($codEntidade, $exercicio, $codPeriodoMovimentacao, $stEntidade)
    {
        $dataFinalCompetencia = $this->getDataFinalCompetenciaPeriodoMovimentacao($codPeriodoMovimentacao, $stEntidade);

        $sql = <<<SQL
SELECT
  LPAD((SELECT cod_entidade
        FROM orcamento.entidade
        WHERE cod_entidade = :cod_entidade
              AND exercicio = :exercicio) :: VARCHAR, 2, '0')                                                 AS numero_entidade,
  to_char(:data_final_competencia :: DATE), 'mm/yyyy') AS mes_ano,
  LPAD(estagiario_estagio.numero_estagio, 8, '0')                                                             AS numero_estagio,
  RPAD(sw_cgm.nom_cgm, 60, ' ')                                                                               AS nom_cgm,
  to_char(estagiario_estagio.dt_inicio, 'ddmmyyyy')                                                           AS data_inicio,
  to_char(estagiario_estagio.dt_final, 'ddmmyyyy')                                                            AS data_final,
  to_char(estagiario_estagio.dt_renovacao, 'ddmmyyyy')                                                        AS data_renovacao,
  RPAD(orgao_descricao.descricao, 60, ' ')                                                                    AS descricao_lotacao,
  RPAD(LOCAL.cod_local :: VARCHAR, 60, ' ')                                                                   AS descricao_local
FROM estagio.estagiario_estagio
  INNER JOIN organograma.orgao_descricao ON orgao_descricao.cod_orgao = estagiario_estagio.cod_orgao
                                            AND orgao_descricao.timestamp =
                                                (SELECT max(TIMESTAMP)
                                                 FROM organograma.orgao_descricao od
                                                 WHERE od.cod_orgao = orgao_descricao.cod_orgao
                                                       AND od.TIMESTAMP <=
                                                           (SELECT ultimotimestampperiodomovimentacao(:cod_periodo_movimentacao, ':cod_entidade')) :: TIMESTAMP)
  LEFT JOIN estagio.estagiario_estagio_local ON estagiario_estagio_local.cod_estagio = estagiario_estagio.cod_estagio
                                                AND estagiario_estagio_local.numcgm = estagiario_estagio.cgm_estagiario
                                                AND estagiario_estagio_local.cod_curso = estagiario_estagio.cod_curso
                                                AND estagiario_estagio_local.cgm_instituicao_ensino = estagiario_estagio.cgm_instituicao_ensino
  LEFT JOIN organograma.local ON LOCAL.cod_local = estagiario_estagio_local.cod_local
  INNER JOIN sw_cgm_pessoa_fisica ON sw_cgm_pessoa_fisica.numcgm = estagiario_estagio.cgm_estagiario
  INNER JOIN sw_cgm ON sw_cgm.numcgm = sw_cgm_pessoa_fisica.numcgm
WHERE estagiario_estagio.dt_inicio <=
      (:data_final_competencia) :: DATE
      AND (estagiario_estagio.dt_final >=
           (:data_final_competencia) :: DATE
           OR estagiario_estagio.dt_final IS NULL)
ORDER BY mes_ano
SQL;

        return $this->getQueryResults($sql, [
            'data_final_competencia'   => $dataFinalCompetencia,
            'cod_periodo_movimentacao' => $codPeriodoMovimentacao,
            'cod_entidade'             => $codEntidade,
            'exercicio'                => $exercicio,
        ]);
    }
}
