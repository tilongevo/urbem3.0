<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class LiquidacaoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class LiquidacaoModel extends AbstractTransparenciaModel
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
SELECT LPAD(tabela.exercicio :: VARCHAR, 4, '0') AS exercicio,
       (tabela.exercicio || LPAD(tabela.cod_entidade :: VARCHAR, 2, '0') || LPAD(tabela.cod_empenho :: VARCHAR, 7, '0')) AS cod_empenho,
       LPAD(tabela.cod_entidade :: VARCHAR, 2, '0') AS cod_entidade,
       LPAD(tabela.cod_nota :: VARCHAR, 20, '0') AS cod_nota,
       TO_CHAR(tabela.data_pagamento, 'ddmmyyyy') AS data_pagamento,
       LPAD(REPLACE(REPLACE(tabela.valor_liquidacao :: VARCHAR, '-', ''), '.', ''), 13, '0') AS valor_liquidacao,
       RPAD(tabela.sinal_valor, 1, ' ') AS sinal_valor,
       RPAD(tabela.observacao, 165, ' ') AS observacao,
       tabela.ordem
FROM tcers.fn_exportacao_liquidacao(:exercicio, :dtInicial, :dtFinal, '$entidades', '') AS tabela (exercicio CHAR(4), cod_empenho INTEGER, cod_entidade INTEGER, cod_nota INTEGER, data_pagamento DATE, valor_liquidacao NUMERIC, sinal_valor TEXT, observacao VARCHAR, ordem INTEGER, oid OID);
SQL;

        return $this->getQueryResults($sql, [
            'exercicio' => $exercicio,
            'dtInicial' => $dataInicial->format('d/m/Y'),
            'dtFinal'   => $dataFinal->format('d/m/Y'),
        ]);
    }
}
