<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class SubfuncoesModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class SubfuncoesModel extends AbstractTransparenciaModel
{
    /**
     * @return array
     */
    public function getDadosExportacao()
    {
        $sql = <<<SQL
SELECT
  exercicio,
  LPAD(cod_subfuncao :: VARCHAR, 3, '0') AS cod_subfuncao,
  RPAD(descricao, 80, ' ')               AS descricao
FROM orcamento.subfuncao;
SQL;

        return $this->getQueryResults($sql);
    }
}
