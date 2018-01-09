<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class EmpenhoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Empenho
 */
class EmpenhoModel extends AbstractTransparenciaModel
{
    /**
     * @param string|integer $exercicio
     * @param DateTime       $dataInicial
     * @param DateTime       $dataFinal
     * @param string|integer $codEntidade
     *
     * @return array
     */
    public function getDadosExportacao($exercicio, DateTime $dataInicial, DateTime $dataFinal, $codEntidade)
    {
        $dataInicial = $dataInicial->format('d/m/Y');
        $dataFinal = $dataFinal->format('d/m/Y');

        $sql = <<<SQL
SELECT
  LPAD(CAST(tabela.cod_entidade AS TEXT), 2, '0')                            AS cod_entidade,
  LPAD(CAST(COALESCE(tabela.num_orgao, 0) AS TEXT), 5, '0')                  AS num_orgao,
  LPAD(CAST(COALESCE(tabela.num_unidade, 0) AS TEXT), 5, '0')                AS num_unidade,
  LPAD(CAST(COALESCE(tabela.cod_funcao, 0) AS TEXT), 2, '0')                 AS cod_funcao,
  LPAD(CAST(COALESCE(tabela.cod_subfuncao, 0) AS TEXT), 3, '0')              AS cod_subfuncao,
  LPAD(CAST(COALESCE(tabela.cod_programa, 0) AS TEXT), 4, '0')               AS cod_programa,
  '000'                                                                      AS cod_subprograma,
  LPAD(CAST(COALESCE(tabela.num_pao, 0) AS TEXT), 5, '0')                    AS num_pao,
  LPAD(REPLACE(COALESCE(tabela.cod_estrutural, '0')::TEXT,'.',''), 15, '0') as cod_estrutural,
  LPAD(CAST(COALESCE(tabela.cod_recurso, 0) AS TEXT), 4, '0')                AS cod_recurso,
  '0000'                                                                     AS contrapartida,
  LPAD(CAST((tabela.exercicio || LPAD(tabela.cod_entidade :: VARCHAR, 2, '0') ||
             LPAD(tabela.cod_empenho :: VARCHAR, 7, '0')) AS TEXT), 13, '0') AS num_empenho,
  to_char(tabela.dt_empenho, 'ddmmyyyy')                                     AS dt_empenho,
  LPAD(REPLACE(cast(tabela.vl_empenhado AS VARCHAR), '.', ''), 13, '0')      AS vl_empenhado,
  RPAD(tabela.sinal, 1, ' ')                                                 AS sinal,
  LPAD(CAST(tabela.cgm AS TEXT), 10, '0')                                    AS cgm,
  LPAD(CAST(tabela.exercicio AS TEXT), 4, '0')                               AS exercicio,
  RPAD(REGEXP_REPLACE(tabela.historico, '\r|\n', '', 'g'), 165, ' ')         AS historico,
  RPAD(COALESCE(tabela.nro_licitacao, ''), 10, ' ')                          AS nro_licitacao,
  RPAD(tabela.nom_modalidades, 30, ' ')                                      AS nom_modalidades
FROM  public.fn_transparenciaExportacaoEmpenho('$exercicio', '$dataInicial', '$dataFinal',
                                              '$codEntidade') AS tabela ( num_orgao INTEGER, num_unidade INTEGER, cod_funcao INTEGER, cod_subfuncao INTEGER, cod_programa INTEGER, num_pao INTEGER, cod_recurso INTEGER, cod_estrutural VARCHAR, cod_empenho INTEGER, dt_empenho DATE, vl_empenhado NUMERIC, sinal VARCHAR, cgm INTEGER, historico VARCHAR, cod_pre_empenho INTEGER, exercicio CHAR(4), cod_entidade INTEGER, ordem INTEGER, oid OID, caracteristica INTEGER, modalidade INTEGER, nro_licitacao TEXT, nom_modalidades TEXT, preco TEXT )
ORDER BY tabela.exercicio,
  tabela.cod_empenho,
  tabela.ordem;
SQL;

        return $this->getQueryResults($sql);
    }
}
