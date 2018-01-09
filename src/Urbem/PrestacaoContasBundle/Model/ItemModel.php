<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class ItemModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Empenho
 */
class ItemModel extends AbstractTransparenciaModel
{
    /**
     * @param string|integer $exercicio
     * @param DateTime       $dataInicial
     * @param DateTime       $dataFinal
     * @param array          $entidades
     *
     * @return array
     */
    public function getDadosExportacao($exercicio, DateTime $dataInicial, DateTime $dataFinal, $entidades)
    {
        $entidades = implode(', ', $entidades);

        $sql = <<<SQL
SELECT
  LPAD((empenho.exercicio || LPAD(empenho.cod_entidade :: VARCHAR, 2, '0') ||
        LPAD(empenho.cod_empenho :: VARCHAR, 7, '0')), 13, '0')        AS numero_empenho,
  LPAD(empenho.cod_entidade :: TEXT, 2, '0')                           AS cod_entidade,
  empenho.exercicio                                                    AS exercicio,
  TO_CHAR(empenho.dt_empenho, 'ddmmyyyy')                              AS DATA,
  LPAD(item_pre_empenho.num_item :: TEXT, 8, '0')                      AS numero_item,
  RPAD(item_pre_empenho.nom_item, 160, ' ')                            AS descricao,
  RPAD(item_pre_empenho.nom_unidade, 80, ' ')                          AS unidade,
  LPAD(REPLACE(item_pre_empenho.vl_total :: TEXT, '.', ''), 13, '0')   AS valor,
  LPAD(REPLACE(item_pre_empenho.quantidade :: TEXT, '.', ''), 13, '0') AS quantidade,
  '+'                                                                  AS sinal_valor,
  RPAD(item_pre_empenho.complemento, 500, ' ')                         AS complemento
FROM empenho.item_pre_empenho
  INNER JOIN empenho.pre_empenho ON pre_empenho.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                                    AND pre_empenho.exercicio = item_pre_empenho.exercicio
  INNER JOIN empenho.empenho ON empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
                                AND empenho.exercicio = pre_empenho.exercicio
WHERE empenho.exercicio = :exercicio
      AND empenho.dt_empenho BETWEEN to_date(:dtInicial, 'dd/mm/yyyy') AND to_date(:dtFinal, 'dd/mm/yyyy')
      AND empenho.cod_entidade IN ($entidades)
UNION ALL
SELECT
  LPAD((empenho.exercicio || LPAD(empenho.cod_entidade :: VARCHAR, 2, '0') ||
        LPAD(empenho.cod_empenho :: VARCHAR, 7, '0')), 13, '0')            AS numero_empenho,
  LPAD(empenho.cod_entidade :: TEXT, 2, '0')                               AS cod_entidade,
  empenho.exercicio                                                        AS exercicio,
  TO_CHAR(empenho_anulado_item.timestamp :: DATE, 'ddmmyyyy')              AS DATA,
  LPAD(empenho_anulado_item.num_item :: TEXT, 8, '0')                      AS numero_item,
  RPAD('Estorno de Empenho', 160, ' ')                                     AS descricao,
  RPAD('', 80, ' ')                                                        AS unidade,
  LPAD(REPLACE(empenho_anulado_item.vl_anulado :: TEXT, '.', ''), 13, '0') AS valor,
  LPAD(0 :: TEXT, 13, '0')                                                 AS quantidade,
  '-'                                                                      AS sinal_valor,
  RPAD(empenho_anulado.motivo, 500, ' ')                                   AS complemento
FROM empenho.empenho_anulado_item
  INNER JOIN empenho.empenho_anulado ON empenho_anulado.exercicio = empenho_anulado_item.exercicio
                                        AND empenho_anulado.cod_entidade = empenho_anulado_item.cod_entidade
                                        AND empenho_anulado.cod_empenho = empenho_anulado_item.cod_empenho
                                        AND empenho_anulado.timestamp = empenho_anulado_item.timestamp
  INNER JOIN empenho.empenho ON empenho.cod_empenho = empenho_anulado.cod_empenho
                                AND empenho.exercicio = empenho_anulado.exercicio
                                AND empenho.cod_entidade = empenho_anulado.cod_entidade
WHERE empenho.exercicio = :exercicio
      AND empenho.dt_empenho BETWEEN to_date(:dtInicial, 'dd/mm/yyyy') AND to_date(:dtFinal, 'dd/mm/yyyy')
      AND empenho.cod_entidade IN ($entidades)
ORDER BY cod_entidade;
SQL;

        return $this->getQueryResults($sql, [
            'exercicio' => $exercicio,
            'dtInicial' => $dataInicial->format('d/m/Y'),
            'dtFinal'   => $dataFinal->format('d/m/Y'),
        ]);
    }

}
