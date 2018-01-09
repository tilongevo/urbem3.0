<?php

namespace Urbem\PrestacaoContasBundle\Model;

use Urbem\CoreBundle\Entity\Administracao\Modulo;

/**
 * Class BalanceteReceitaModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Orcamento
 */
class BalanceteReceitaModel extends AbstractTransparenciaModel
{
    /**
     * @param $exercicio
     *
     * @return string
     */
    public function getTipoEntidade($exercicio)
    {
        $sql = <<<SQL
SELECT
  cod_modulo,
  parametro,
  valor,
  exercicio
FROM administracao.configuracao
WHERE cod_modulo = :cod_modulo
      AND parametro LIKE ('%cod_entidade%')
      AND valor = '2'
      AND exercicio = :exercicio;
SQL;

        $result = $this->getQueryResults($sql, [
            'cod_modulo' => Modulo::MODULO_ORCAMENTO,
            'exercicio'  => $exercicio,
        ], true);

        preg_match_all('/\_(prefeitura|camara|rpps)$/', $result['parametro'], $matches, PREG_SET_ORDER);

        if (!preg_match('/\_(prefeitura|camara|rpps)$/', $result['parametro'])) {
            $tipoEntidade = 'outros';
        } else {
            $tipoEntidade = reset($matches)[1];
        }

        return $tipoEntidade;
    }

    /**
     * @param $parametro
     * @param $exercicio
     *
     * @return mixed
     */
    public function getConfiguracaoValor($parametro, $exercicio)
    {
        $sql = <<<SQL
SELECT
  cod_modulo,
  parametro,
  valor,
  exercicio
FROM administracao.configuracao
WHERE cod_modulo = :cod_modulo
      AND parametro LIKE ('$parametro%')
      AND exercicio = :exercicio;
SQL;

        $result = $this->getQueryResults($sql, [
            'cod_modulo' => Modulo::MODULO_TRANSPARENCIA,
            'exercicio'  => $exercicio,
        ], true);

        return $result['valor'];
    }

    /**
     * @param string     $exercicio
     * @param \DateTime  $dataInicial
     * @param \DateTime  $dataFinal
     * @param string|int $codEntidade
     *
     * @return mixed
     */
    public function getDadosExportacao($exercicio, \DateTime $dataInicial, \DateTime $dataFinal, $codEntidade)
    {
        $tipoEntidade = $this->getTipoEntidade($exercicio);

        $unidade = $this->getConfiguracaoValor('unidade_' . $tipoEntidade, $exercicio);
        $orgao = $this->getConfiguracaoValor('orgao_' . $tipoEntidade, $exercicio);

        if (is_null($unidade) || is_null($orgao)) {
            $unidade = 0;
            $orgao = 0;
        }

        $sql = <<<SQL
SELECT
  LPAD(:cod_entidade, 2, '0')                                                           AS entidade,
  LPAD(replace(tabela.cod_estrutural, '.', ''), 20, '0')                                AS cod_estrutural,
  LPAD(:unidade, 5, '0')                                                                AS unidade,
  LPAD(:orgao, 5, '0')                                                                  AS orgao,
  LPAD(replace(coalesce(tabela.vl_original, 0.00) :: VARCHAR, '.', ''), 13, '0')        AS vl_original,
  LPAD(replace(coalesce(tabela.ar_jan, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_jan,
  LPAD(replace(coalesce(tabela.ar_fev, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_fev,
  LPAD(replace(coalesce(tabela.ar_mar, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_mar,
  LPAD(replace(coalesce(tabela.ar_abr, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_abr,
  LPAD(replace(coalesce(tabela.ar_mai, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_mai,
  LPAD(replace(coalesce(tabela.ar_jun, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_jun,
  LPAD(replace(coalesce(tabela.ar_jul, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_jul,
  LPAD(replace(coalesce(tabela.ar_ago, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_ago,
  LPAD(replace(coalesce(tabela.ar_set, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_set,
  LPAD(replace(coalesce(tabela.ar_out, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_out,
  LPAD(replace(coalesce(tabela.ar_nov, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_nov,
  LPAD(replace(coalesce(tabela.ar_dez, 0.00) :: VARCHAR, '.', ''), 13, '0')             AS ar_dez,
  LPAD(tabela.cod_recurso, 4, '0')                                                      AS cod_recurso,
  RPAD(tabela.descricao, 170, ' ')                                                      AS descricao,
  cast(orcamento.fn_tipo_conta_receita(':exercicio', tabela.cod_estrutural) AS VARCHAR) AS tipo,
  RPAD(CAST(publico.fn_nivel(tabela.cod_estrutural) AS TEXT), 2, ' ')                   AS nivel
FROM orcamento.fn_balancete_receita_transparencia(:exercicio, '', :dataInicial, :dataFinal, :cod_entidade, '',
                                                  '', '', '', '', '', '',
                                                  :mes) AS tabela (cod_estrutural VARCHAR(150), cod_receita INTEGER, cod_recurso VARCHAR, descricao VARCHAR(160), vl_original NUMERIC, ar_jan NUMERIC, ar_fev NUMERIC, ar_mar NUMERIC, ar_abr NUMERIC, ar_mai NUMERIC, ar_jun NUMERIC, ar_jul NUMERIC, ar_ago NUMERIC, ar_set NUMERIC, ar_out NUMERIC, ar_nov NUMERIC, ar_dez NUMERIC)
WHERE cast(publico.fn_nivel(tabela.cod_estrutural) AS INTEGER) <> 0
ORDER BY entidade,
  tabela.cod_estrutural;
SQL;

        return $this->getQueryResults($sql, [
            'cod_entidade' => $codEntidade,
            'unidade'      => $unidade,
            'orgao'        => $orgao,
            'exercicio'    => $exercicio,
            'dataInicial'  => $dataInicial->format('d/m/Y'),
            'dataFinal'    => $dataFinal->format('d/m/Y'),
            'mes'          => $dataFinal->format('m'),
        ]);
    }
}
