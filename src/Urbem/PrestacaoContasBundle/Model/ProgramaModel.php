<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class OrgaoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class ProgramaModel extends AbstractTransparenciaModel
{
    /**
     * @param string|integer $exercicio
     *
     * @return array
     */
    public function getDadosExportacao($exercicio)
    {
        $samLinkHost = $this->getSamLinkHost();

        $sql = <<<SQL
SELECT
  exercicio,
  LPAD(cod_programa :: VARCHAR, 4, '0') AS cod_programa,
  RPAD(descricao, 80, ' ')              AS descricao
FROM (SELECT
        orcamento.programa.exercicio :: INTEGER,
        CASE
        WHEN ppa.programa.num_programa IS NOT NULL
          THEN ppa.programa.num_programa
        ELSE orcamento.programa.cod_programa
        END AS cod_programa,
        CASE
        WHEN ppa.programa.num_programa IS NOT NULL
          THEN regexp_replace(programa_dados.identificacao, E'[\\n\\r]+', '', 'g')
        ELSE regexp_replace(orcamento.programa.descricao, E'[\\n\\r]+', '', 'g')
        END AS descricao
      FROM orcamento.programa
        LEFT JOIN orcamento.programa_ppa_programa
          ON programa_ppa_programa.cod_programa = orcamento.programa.cod_programa
             AND programa_ppa_programa.exercicio = orcamento.programa.exercicio
        LEFT JOIN ppa.programa ON ppa.programa.cod_programa = programa_ppa_programa.cod_programa
        LEFT JOIN ppa.programa_dados ON programa_dados.cod_programa = ppa.programa.cod_programa
                                        AND programa_dados.timestamp_programa_dados =
                                            ppa.programa.ultimo_timestamp_programa_dados
SQL;

        if (!is_null($samLinkHost)) {
            $sql .= <<<SQL
UNION
SELECT 2004 AS exercicio,
       LPAD(to_number(cod_programa,'9999') :: VARCHAR, 4, '0') AS cod_programa,
       RPAD('PROGRAMA', 80, ' ') AS descricao
FROM samlink.vw_siam_programa_2004
SQL;
        }

        $sql .= ') AS tabela WHERE tabela.exercicio <= :exercicio;';

        return $this->getQueryResults($sql, ['exercicio' => $exercicio]);
    }
}
