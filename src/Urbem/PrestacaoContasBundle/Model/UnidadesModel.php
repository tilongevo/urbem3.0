<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class UnidadesModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class UnidadesModel extends AbstractTransparenciaModel
{
    /**
     * @return array
     */
    public function getDadosExportacao()
    {
        $sql = <<<SQL
SELECT
  exercicio,
  LPAD(num_orgao :: VARCHAR, 5, '0')   AS num_orgao,
  LPAD(num_unidade :: VARCHAR, 5, '0') AS num_unidade,
  RPAD(nom_unidade, 80, ' ')           AS nom_unidade
FROM orcamento.unidade;
SQL;

        return $this->getQueryResults($sql);
    }
}
