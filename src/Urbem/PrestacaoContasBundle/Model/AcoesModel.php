<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class PaoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Orcamento
 */
class AcoesModel extends AbstractTransparenciaModel
{
    /**
     * @param $exercicio
     *
     * @return mixed
     */
    public function getDadosExportacao($exercicio)
    {
        $sql = <<<SQL
SELECT
  LPAD(pao.exercicio, 4, '0')                   AS exercicio,
  LPAD(CAST(CASE WHEN ppa.acao.num_acao IS NOT NULL
    THEN
      ppa.acao.num_acao
            ELSE
              pao.num_pao END AS TEXT), 5, '0') AS num_pao,
  SUBSTR(pao.nom_pao, 0, 80)                    AS nom_pao,
  pao.detalhamento
FROM orcamento.pao
  LEFT JOIN orcamento.pao_ppa_acao
    ON (pao_ppa_acao.exercicio = pao.exercicio
        AND pao_ppa_acao.num_pao = pao.num_pao)
  LEFT JOIN ppa.acao
    ON (acao.cod_acao = pao_ppa_acao.cod_acao)
WHERE pao.exercicio = :exercicio
ORDER BY num_pao;
SQL;

        return $this->getQueryResults($sql, ['exercicio' => $exercicio]);
    }
}
