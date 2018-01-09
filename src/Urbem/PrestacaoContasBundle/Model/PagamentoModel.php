<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class LiquidacaoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class PagamentoModel extends AbstractTransparenciaModel
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
SELECT
  LPAD(tabela.exercicio_empenho :: VARCHAR, 4, '0')   AS exercicio_empenho,
  (tabela.exercicio_empenho || LPAD(tabela.cod_entidade :: VARCHAR, 2, '0') ||
   LPAD(tabela.cod_empenho :: VARCHAR, 7, '0'))       AS cod_empenho,
  LPAD(tabela.cod_entidade :: VARCHAR, 2, '0')        AS cod_entidade,
  LPAD(cod_ordem :: VARCHAR, 20, '0')                 AS cod_ordem,
  LPAD(REPLACE(vl_pago :: VARCHAR, '.', ''), 13, '0') AS vl_pago,
  RPAD(observacao, 165, ' ')                          AS observacao,
  TO_CHAR(data_pagamento, 'ddmmyyyy')                 AS data_pagamento,
  sinal_valor,
  cod_operacao,
  debito_codigo_conta_verificacao,
  credito_codigo_conta_verificacao
FROM tcers.fn_exportacao_pagamento(:exercicio, :dtInicial, :dtFinal, '$entidades', '') AS tabela(exercicio_empenho CHAR(4), cod_empenho INTEGER, cod_entidade INTEGER, cod_ordem INTEGER, vl_pago NUMERIC, observacao VARCHAR, data_pagamento DATE, sinal_valor TEXT, cod_operacao INTEGER, debito_codigo_conta_verificacao VARCHAR, credito_codigo_conta_verificacao VARCHAR, oid OID);
SQL;

        return $this->getQueryResults($sql, [
            'exercicio' => $exercicio,
            'dtInicial' => $dataInicial->format('d/m/Y'),
            'dtFinal'   => $dataFinal->format('d/m/Y'),
        ]);
    }
}
