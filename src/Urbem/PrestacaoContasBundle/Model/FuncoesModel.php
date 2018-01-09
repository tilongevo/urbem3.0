<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class FuncoesModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Orcamento
 */
class FuncoesModel extends AbstractTransparenciaModel
{
    /**
     * @return array
     */
    public function getDadosExportacao()
    {
        $sql = <<<SQL
SELECT
  LPAD(exercicio, 4, ' ')          AS exercicio,
  RPAD(cod_funcao :: TEXT, 2, '0') AS cod_funcao,
  RPAD(descricao, 80, ' ')         AS descricao
FROM orcamento.funcao;
SQL;

        return $this->getQueryResults($sql);
    }
}
