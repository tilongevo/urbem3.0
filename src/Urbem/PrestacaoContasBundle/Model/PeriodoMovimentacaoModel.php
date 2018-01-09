<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class PeriodoMovimentacaoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class PeriodoMovimentacaoModel extends AbstractTransparenciaModel
{
    /**
     * @param          $stEntidade
     * @param DateTime $dtInicial
     * @param DateTime $dtFinal
     *
     * @return mixed
     */
    public function getFolhaSituacaoPeriodo($stEntidade, DateTime $dtInicial, DateTime $dtFinal)
    {
        $dataFinalCompetencia = $this->getDataFinalCompetenciaPeriodoMovimentacao($codPeriodoMovimentacao, $stEntidade);

        $sql = <<<SQL
SELECT
  max(fl.cod_periodo_movimentacao) AS cod_periodo_movimentacao,
  to_char(fl.timestamp, 'MM/YYYY') AS mes_ano
FROM
  folhapagamento$stEntidade.folha_situacao AS fl, folhapagamento$stEntidade.periodo_movimentacao AS pm
WHERE pm.cod_periodo_movimentacao = fl.cod_periodo_movimentacao
      AND fl.situacao = 'f'
      AND pm.dt_final BETWEEN to_date(:dtInicial, 'MM/YYYY') AND to_date(:dtFinal, 'MM/YYYY')
GROUP BY to_char(fl.timestamp, 'MM/YYYY')
ORDER BY mes_ano
SQL;

        return $this->getQueryResults($sql, [
            'dtInicial' => $dtInicial->format('m/Y'),
            'dtFinal'   => $dtFinal->format('m/Y'),
        ]);
    }

    /**
     * @param string|integer $stEntidade
     * @param string|integer $codPeriodoMovimentacao
     *
     * @return mixed
     */
    public function getUltimoTimestampPeriodoMovimentacao($stEntidade, $codPeriodoMovimentacao)
    {
        $sql = <<<SQL
SELECT ultimotimestampperiodomovimentacao(:cod_periodo_movimentacao, :alias_entidade);
SQL;

        return $this->getQueryResults($sql, [
            'cod_periodo_movimentacao' => $codPeriodoMovimentacao,
            'alias_entidade' => $stEntidade
        ], true);
    }

    /**
     * @param DateTime $dataInicial
     * @param DateTime $dataFinal
     * @param          $schema
     *
     * @return mixed
     */
    public function getIntervaloPeriodosMovimentacaoCompetencia(DateTime $dataInicial, DateTime $dataFinal, $schema)
    {
        $sql = <<<SQL
SELECT *
FROM $schema.periodo_movimentacao AS periodo_movimentacao
WHERE periodo_movimentacao.dt_final BETWEEN to_date(:dataIncial, 'YYYYMM') AND to_date(:dataFinal, 'YYYYMM') ;
SQL;

        $dataFinal = $dataFinal->setDate(
            $dataFinal->format('Y'),
            ((int) $dataFinal->format('m')) + 1,
            $dataFinal->format('d')
        );

        return $this->getQueryResults($sql, [
            'dataIncial' => $dataInicial->format('Ym'),
            'dataFinal' => $dataFinal->format('Ym')
        ]);
    }

    /**
     * @param string|int $codPeriodoMovimentacao
     * @param string|int $stEntidade
     *
     * @return array
     */
    protected function getDataFinalCompetenciaPeriodoMovimentacao($codPeriodoMovimentacao, $stEntidade)
    {
        $sql = <<<SQL
SELECT fpm.dt_final
FROM
  folhapagamento$stEntidade.periodo_movimentacao fpm
WHERE fpm.cod_periodo_movimentacao = :codPeriodoMovimentacao;
SQL;

        $result = $this->getQueryResults($sql, [
            'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
        ], true);

        return $result['dt_final'];
    }
}
