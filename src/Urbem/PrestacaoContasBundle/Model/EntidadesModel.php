<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class OrcamentoEntidadeModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class EntidadesModel extends AbstractTransparenciaModel
{
    /**
     * @param string $exercicio
     *
     * @return mixed
     */
    public function getEntidades($exercicio)
    {
        $sql = <<<SQL
SELECT
  e.*,
  tabela.exercicio_atual,
  c.nom_cgm,
  c.numcgm
FROM
  (SELECT
     E.cod_entidade,
     max(E.exercicio)                                           AS exercicio,
     publico.concatenar_hifen(coalesce(EA.exercicio_atual, '')) AS exercicio_atual
   FROM orcamento.entidade AS e
     LEFT OUTER JOIN
     (SELECT
        exercicio AS exercicio_atual,
        cod_entidade
      FROM orcamento.entidade
      WHERE exercicio = :exercicio) AS EA ON (e.cod_entidade = ea.cod_entidade
                                              AND e.exercicio = ea.exercicio_atual)
   GROUP BY E.cod_entidade
   ORDER BY E.cod_entidade) AS tabela,
  orcamento.entidade AS e,
  sw_cgm AS c
WHERE tabela.cod_entidade = e.cod_entidade
      AND tabela.exercicio = e.exercicio
      AND e.numcgm = c.numcgm
      AND tabela.exercicio_atual = :exercicio;
SQL;
        return $this->getQueryResults($sql, ['exercicio' => $exercicio]);
    }

    /**
     * @param string|integer $exercicio
     *
     * @return array
     */
    public function getDadosExportacao($exercicio)
    {
        $queryResult = $this->getEntidades($exercicio);

        $entidades = [];
        foreach ($queryResult as $item) {
            $entidades[] = [
                'cod_entidade' => str_pad($item['cod_entidade'], 2, '0', STR_PAD_LEFT),
                'nom_cgm' => str_pad($item['nom_cgm'], 160, ' ', STR_PAD_RIGHT)
            ];
        }

        return $entidades;
    }
}
