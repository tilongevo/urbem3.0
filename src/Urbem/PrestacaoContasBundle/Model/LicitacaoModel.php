<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class LicitacaoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Licitacao
 */
class LicitacaoModel extends AbstractTransparenciaModel
{
    /**
     * @param string|integer $exercicio
     * @param array $entidades
     * @param DateTime       $dataInicial
     * @param DateTime       $dataFinal
     *
     * @return mixed
     */
    public function getDadosExportacao($exercicio, array $entidades, Datetime $dataInicial, DateTime $dataFinal)
    {
        $entidades = implode(', ', $entidades);

        $sql = <<<SQL
SELECT
  licitacao.exercicio                           AS exercicio_entidade,
  LPAD(licitacao.cod_entidade :: TEXT, 2, '0')  AS cod_entidade,
  LPAD(licitacao.cod_licitacao :: TEXT, 8, '0') AS cod_licitacao,
  RPAD(modalidade.descricao, 50, ' ')           AS modalidade,
  empenho.exercicio                             AS exercicio_empenho,
  LPAD(empenho.cod_empenho :: TEXT, 8, '0')     AS cod_empenho,
  RPAD(tipo_licitacao.descricao, 15, ' ')       AS descricao_tipo_licitacao,
  RPAD(tipo_objeto.descricao, 50, ' ')          AS descricao_tipo_objeto,
  RPAD(objeto.descricao, 500, ' ')              AS descricao_objeto
FROM licitacao.licitacao
  INNER JOIN compras.tipo_licitacao
    ON tipo_licitacao.cod_tipo_licitacao = licitacao.cod_tipo_licitacao
  INNER JOIN compras.modalidade
    ON modalidade.cod_modalidade = licitacao.cod_modalidade
  INNER JOIN compras.objeto
    ON objeto.cod_objeto = licitacao.cod_objeto
  INNER JOIN compras.tipo_objeto
    ON tipo_objeto.cod_tipo_objeto = licitacao.cod_tipo_objeto
  INNER JOIN compras.mapa
    ON mapa.exercicio = licitacao.exercicio_mapa
       AND mapa.cod_mapa = licitacao.cod_mapa
  INNER JOIN compras.mapa_cotacao
    ON mapa_cotacao.exercicio_mapa = mapa.exercicio
       AND mapa_cotacao.cod_mapa = mapa.cod_mapa
  INNER JOIN compras.cotacao
    ON cotacao.exercicio = mapa_cotacao.exercicio_cotacao
       AND cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
  LEFT JOIN compras.julgamento
    ON julgamento.exercicio = cotacao.exercicio
       AND julgamento.cod_cotacao = cotacao.cod_cotacao
  LEFT JOIN compras.julgamento_item
    ON julgamento_item.exercicio = cotacao.exercicio
       AND julgamento_item.cod_cotacao = cotacao.cod_cotacao
  LEFT JOIN empenho.item_pre_empenho_julgamento
    ON item_pre_empenho_julgamento.exercicio_julgamento = julgamento_item.exercicio
       AND item_pre_empenho_julgamento.cod_cotacao = julgamento_item.cod_cotacao
       AND item_pre_empenho_julgamento.cod_item = julgamento_item.cod_item
       AND item_pre_empenho_julgamento.lote = julgamento_item.lote
       AND item_pre_empenho_julgamento.cgm_fornecedor = julgamento_item.cgm_fornecedor
  LEFT JOIN empenho.item_pre_empenho
    ON item_pre_empenho.cod_pre_empenho = item_pre_empenho_julgamento.cod_pre_empenho
       AND item_pre_empenho.exercicio = item_pre_empenho_julgamento.exercicio
       AND item_pre_empenho.num_item = item_pre_empenho_julgamento.num_item
  LEFT JOIN empenho.pre_empenho
    ON pre_empenho.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
       AND pre_empenho.exercicio = item_pre_empenho.exercicio
  LEFT JOIN empenho.empenho
    ON empenho.exercicio = pre_empenho.exercicio
       AND empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
WHERE licitacao.exercicio = :exercicio
      AND licitacao.cod_entidade IN ($entidades)
      AND licitacao.timestamp BETWEEN TO_DATE(:dtInicial, 'DD-MM-YYYY') AND TO_DATE(:dtFinal, 'DD-MM-YYYY')
GROUP BY licitacao.exercicio
  , licitacao.cod_entidade
  , licitacao.cod_licitacao
  , modalidade.descricao
  , empenho.exercicio
  , empenho.cod_empenho
  , tipo_licitacao.descricao
  , tipo_objeto.descricao
  , objeto.descricao;
SQL;

        return $this->getQueryResults($sql, [
            'exercicio' => $exercicio,
            'dtInicial' => $dataInicial->format('d/m/Y'),
            'dtFinal' => $dataFinal->format('d/m/y'),
        ]);
    }
}
