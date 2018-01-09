<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class FuncoesModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Orcamento
 */
class RubricaModel extends AbstractTransparenciaModel
{
    /**
     * @param string|integer $exercicio
     *
     * @return array
     */
    public function getDadosExportacao($exercicio)
    {
        $sql = <<<SQL
SELECT
  LPAD(exercicio, 4, '0')       AS exercicio,
  LPAD(cod_estrutural, 15, '0') AS cod_estrutural,
  RPAD(descricao, 110, ' ')     AS descricao,
  RPAD(tnc, 1, ' ')             AS tnc,
  LPAD(nnc :: VARCHAR, 2, '0')  AS nnc
FROM (SELECT
        OD.exercicio,
        replace(OD.cod_estrutural, '.', '')                           AS cod_estrutural,
        OD.descricao,
        tcers.tipo_conta_rubrica('OD.exercicio', 'OD.cod_estrutural') AS tnc,
        publico.fn_nivel(OD.cod_estrutural)                           AS nnc
      FROM orcamento.conta_despesa AS OD
      WHERE OD.exercicio <= :exercicio
SQL;

        if (!is_null($this->getSamLinkHost())) {
            $sql .= <<<SQL
SELECT
  '2004'                                                              AS exercicio,
  LPAD(cod_estrutural, 15, '0')                                       AS cod_estrutural,
  RPAD('RUBRICA', 110, ' ')                                           AS descricao,
  RPAD(tipo , 1, ' ')                                                 AS tnc,
  LPAD(publico.fn_nivel(substr(cod_estrutural, 1, 1) || '.' ||
                   substr(cod_estrutural, 2, 1) || '.' ||
                   substr(cod_estrutural, 3, 2) || '.' ||
                   substr(cod_estrutural, 5, 2) || '.' ||
                   substr(cod_estrutural, 7, 2) || '.' ||
                   substr(cod_estrutural, 9, 2) || '.' ||
                   substr(cod_estrutural, 11, 2)) :: VARCHAR, 2, '0') AS nnc
FROM
  samlink.vw_siam_elemento_despesa_2004
WHERE trim(cod_estrutural) <> '' AND cod_estrutural IS NOT NULL               
SQL;
        }

        $sql .= ") AS tabela;";

        return $this->getQueryResults($sql, ['exercicio' => $exercicio]);
    }
}
