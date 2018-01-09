<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class FuncoesModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Orcamento
 */
class RecursoModel extends AbstractTransparenciaModel
{
    /**
     * @return array
     */
    public function getDadosExportacao($exercicio)
    {
        $sql = <<<SQL
SELECT
  LPAD(cod_recurso::VARCHAR, 4, '0') AS cod_recurso,
  RPAD(nom_recurso, 80, ' ') AS nom_recurso
FROM orcamento.recurso
WHERE exercicio = :exercicio
SQL;

        return $this->getQueryResults($sql, ['exercicio' => $exercicio]);
    }
}
