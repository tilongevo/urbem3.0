<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateInterval;
use DateTime;

/**
 * Class RemuneracaoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class RemuneracaoModel extends AbstractTransparenciaModel
{
    /**
     * @param DateTime $dtInicial
     * @param DateTime $dtFinal
     *
     * @return array
     */
    public function getIntervaloPeriodosMovimentacaoDaSituacao(DateTime $dtInicial, DateTime $dtFinal)
    {
        $sql = <<<SQL
SELECT periodo_movimentacao.cod_periodo_movimentacao,
  periodo_movimentacao.dt_inicial,
  periodo_movimentacao.dt_final
FROM folhapagamento.periodo_movimentacao
  INNER JOIN folhapagamento.periodo_movimentacao_situacao ON periodo_movimentacao_situacao.cod_periodo_movimentacao = periodo_movimentacao.cod_periodo_movimentacao
  INNER JOIN
  (SELECT periodo_movimentacao_situacao.cod_periodo_movimentacao,
     max(periodo_movimentacao_situacao.timestamp) AS TIMESTAMP
   FROM folhapagamento.periodo_movimentacao_situacao
   GROUP BY periodo_movimentacao_situacao.cod_periodo_movimentacao
   ORDER BY 1) AS max_periodo_movimentacao_situacao ON max_periodo_movimentacao_situacao.cod_periodo_movimentacao = periodo_movimentacao_situacao.cod_periodo_movimentacao
                                                       AND max_periodo_movimentacao_situacao.TIMESTAMP = periodo_movimentacao_situacao.TIMESTAMP
WHERE periodo_movimentacao.dt_final BETWEEN to_date(:competenciaInicial, 'YYYYMM') AND to_date(:competenciaFinal, 'YYYYMM')
      AND periodo_movimentacao_situacao.situacao = 'f';
SQL;

        return $this->getQueryResults($sql, [
            'competenciaInicial' => $dtInicial->format('Ym'),
            'competenciaFinal'   => $dtFinal->add((new DateInterval('P1M')))->format('Ym'),
        ]);
    }

    /**
     * @param DateTime   $dtCompetencia
     * @param string|int $codEntidade
     * @param string|int $exercicio
     * @param string     $stEntidade
     * @param string|int $codPeriodoMovimentacao
     */
    public function getDadosExportacao(DateTime $dtCompetencia, $codEntidade, $exercicio, $stEntidade, $codPeriodoMovimentacao)
    {
        $sql = <<<SQL
SELECT
  LPAD(cod_entidade :: VARCHAR, 2, '0')                                                            AS cod_entidade,
  LPAD(registro :: VARCHAR, 8, '0')                                                                AS registro,
  RPAD(cgm, 60, ' ')                                                                               AS cgm,
  LPAD(REPLACE(COALESCE(NULLIF(remuneracao_bruta, ''), '0'), '.', ''), 16, '0')                    AS remuneracao_bruta,
  LPAD(REPLACE(COALESCE(NULLIF(redutor_teto, ''), '0'), '.', ''), 16, '0')                         AS redutor_teto,
  LPAD(REPLACE(COALESCE(NULLIF(remuneracao_natalina, ''), '0'), '.', ''), 13,
       '0')                                                                                        AS remuneracao_natalina,
  LPAD(REPLACE(COALESCE(NULLIF(remuneracao_ferias, ''), '0'), '.', ''), 13,
       '0')                                                                                        AS remuneracao_ferias,
  LPAD(REPLACE(COALESCE(NULLIF(remuneracao_outras, ''), '0'), '.', ''), 13,
       '0')                                                                                        AS remuneracao_outras,
  LPAD(REPLACE(COALESCE(NULLIF(deducoes_irrf, ''), '0'), '.', ''), 13, '0')                        AS deducoes_irrf,
  LPAD(REPLACE(COALESCE(NULLIF(deducoes_obrigatorias, ''), '0'), '.', ''), 13,
       '0')                                                                                        AS deducoes_obrigatorias,
  LPAD(REPLACE(COALESCE(NULLIF(demais_deducoes, ''), '0'), '.', ''), 13, '0')                      AS demais_deducoes,
  LPAD(REPLACE(COALESCE(NULLIF(remuneracao_apos_deducoes :: VARCHAR, ''), '0'), '.', ''), 13,
       '0')                                                                                        AS remuneracao_apos_deducoes,
  LPAD(REPLACE(COALESCE(NULLIF(salario_familia, ''), '0'), '.', ''), 13, '0')                      AS salario_familia,
  LPAD(REPLACE(COALESCE(NULLIF(jetons, ''), '0'), '.', ''), 13, '0')                               AS jetons,
  LPAD(REPLACE(COALESCE(NULLIF(verbas, ''), '0'), '.', ''), 13, '0')                               AS verbas,
  RPAD(:mesano, 7, ' ')                                                                            AS mesano
FROM fn_transparencia_remuneracao(:st_entidae, :cod_periodo_movimentacao, :exercicio, :cod_entidade) AS tabela(
     exercicio CHAR(4), cod_entidade INTEGER, cod_periodo_movimentacao INTEGER, registro INTEGER, cod_contrato INTEGER, cgm VARCHAR, remuneracao_bruta VARCHAR, redutor_teto VARCHAR, remuneracao_natalina VARCHAR, remuneracao_ferias VARCHAR, remuneracao_outras VARCHAR, deducoes_irrf VARCHAR, deducoes_obrigatorias VARCHAR, demais_deducoes VARCHAR, salario_familia VARCHAR, jetons VARCHAR, verbas VARCHAR, remuneracao_apos_deducoes NUMERIC
     )
WHERE remuneracao_bruta != '' OR
      redutor_teto != '' OR
      remuneracao_natalina != '' OR
      remuneracao_ferias != '' OR
      remuneracao_outras != '' OR
      deducoes_irrf != '' OR
      deducoes_obrigatorias != '' OR
      demais_deducoes != '' OR
      salario_familia != '' OR
      jetons != '' OR
      verbas != '';
SQL;

        return $this->getQueryResults($sql, [
            'mesano'                   => $dtCompetencia->format('m/Y'),
            'st_entidae'               => $stEntidade,
            'cod_periodo_movimentacao' => $codPeriodoMovimentacao,
            'exercicio'                => $exercicio,
            'cod_entidade'             => $codEntidade,
        ]);
    }
}
