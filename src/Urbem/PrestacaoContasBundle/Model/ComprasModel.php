<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class ComprasModel
 */
class ComprasModel extends AbstractTransparenciaModel
{
    /**
     * @param string|integer $exercicio
     * @param array          $entidades
     * @param DateTime       $dataInicial
     * @param DateTime       $dataFinal
     *
     * @return mixed
     */
    public function getDadosExportacao($exercicio, array $entidades, Datetime $dataInicial, DateTime $dataFinal)
    {
        $entidades = implode(', ', $entidades);

        $sql = <<<SQL
SELECT DISTINCT
  LPAD(CAST(compra_direta.cod_compra_direta AS TEXT), 8, '0')  AS cod_compra_direta,
  LPAD(CAST(compra_direta.exercicio_entidade AS TEXT), 4, '0') AS exercicio_entidade,
  RPAD(modalidade.descricao, 50, ' ')                          AS modalidade,
  LPAD(CAST(empenho.exercicio AS TEXT), 4, '0')                AS exercicio_empenho,
  LPAD(CAST(empenho.cod_empenho AS TEXT), 8, '0')              AS cod_empenho,
  LPAD(CAST(compra_direta.cod_entidade AS TEXT), 2, '0')       AS cod_entidade,
  RPAD(tipo_objeto.descricao, 50, ' ')                         AS descricao_tipo_objeto,
  RPAD(objeto.descricao, 500, ' ')                             AS descricao_objeto,
  RPAD(tipo_licitacao.descricao, 15, ' ')                      AS descricao_tipo_licitacao,
  to_char(julgamento.timestamp :: DATE, 'ddmmyyyy')            AS dt_compra_licitacao
FROM compras.compra_direta
  JOIN compras.mapa
    ON compra_direta.exercicio_mapa = mapa.exercicio
       AND compra_direta.cod_mapa = mapa.cod_mapa
  JOIN compras.objeto
    ON objeto.cod_objeto = mapa.cod_objeto
  JOIN compras.mapa_cotacao
    ON mapa_cotacao.exercicio_mapa = mapa.exercicio
       AND mapa_cotacao.cod_mapa = mapa.cod_mapa
  JOIN compras.cotacao
    ON cotacao.exercicio = mapa_cotacao.exercicio_mapa
       AND cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
  JOIN compras.modalidade
    ON modalidade.cod_modalidade = compra_direta.cod_modalidade
  JOIN compras.tipo_licitacao
    ON tipo_licitacao.cod_tipo_licitacao = mapa.cod_tipo_licitacao
  JOIN compras.tipo_objeto
    ON tipo_objeto.cod_tipo_objeto = compra_direta.cod_tipo_objeto
  LEFT JOIN compras.julgamento
    ON julgamento.exercicio = cotacao.exercicio
       AND julgamento.cod_cotacao = cotacao.cod_cotacao
  LEFT JOIN compras.julgamento_item
    ON julgamento_item.exercicio = julgamento.exercicio
       AND julgamento_item.cod_cotacao = julgamento.cod_cotacao
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
WHERE compra_direta.exercicio_entidade = :exercicio
      AND compra_direta.cod_entidade IN ($entidades)
      AND compra_direta.timestamp BETWEEN TO_DATE(:dtInicial, 'DD-MM-YYYY') AND TO_DATE(:dtFinal, 'DD-MM-YYYY');
SQL;

        return $this->getQueryResults($sql, [
            'exercicio' => $exercicio,
            'dtInicial' => $dataInicial->format('d-m-Y'),
            'dtFinal'   => $dataFinal->format('d-m-Y'),
        ]);
    }
}
