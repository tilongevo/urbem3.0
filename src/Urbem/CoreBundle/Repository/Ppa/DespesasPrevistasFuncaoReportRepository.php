<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Doctrine\ORM;

class DespesasPrevistasFuncaoReportRepository extends ORM\EntityRepository
{

    /**
     * Busca orcamento.funcao por exercicio
     * @param $exercicio
     * @return array
     */
    public function findAllFuncaoPorExercicio($exercicio)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT
                         sw_fn_mascara_dinamica
                         (
                             '99',
                             ''||cod_funcao
                         ) AS cod_funcao,
                         exercicio,
                         descricao
                      FROM
                        orcamento.funcao
                     WHERE  exercicio = :exercicio  ORDER BY cod_funcao
                ")
        );

        $query->bindValue('exercicio', $exercicio);
        $query->execute();

        return $this->hydrate($query->fetchAll(), 'cod_funcao', 'descricao');
    }

    /**
     * Trata para receber o array no formato esperado chave=>valor
     * @param $array
     * @param $chave
     * @param $valor
     * @return array
     */
    private function hydrate($array, $chave, $valor)
    {
        $retorno = [];
        if(!empty($array)){
            foreach ($array as $orgao) {
                $retorno[$orgao[$chave] .' - '.$orgao[$valor]] = $orgao[$chave];
            }
        }
        return $retorno;
    }


    /**
     * Teste da query, do relatório Despesa previsao funcao
     * @param array $params
     * @return array
     */
    public function queryRelatorio(array $params)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf(" SELECT funcao.cod_funcao
                            ,  funcao.descricao
                            ,  despesa.ano
                            ,  COALESCE(SUM(despesa.valor_corrente), 0.00) AS sum_valor_corrente
                            ,  COALESCE(SUM(despesa.valor_capital), 0.00) AS sum_valor_capital
                          FROM ppa.macro_objetivo
                    INNER JOIN ppa.programa_setorial
                            ON programa_setorial.cod_macro = macro_objetivo.cod_macro
                    INNER JOIN ppa.programa
                            ON programa.cod_setorial = programa_setorial.cod_setorial
                           AND programa.ativo = 't'
                    INNER JOIN ppa.acao
                            ON acao.cod_programa = programa.cod_programa
                    INNER JOIN ppa.acao_dados
                            ON acao_dados.cod_acao             = acao.cod_acao
                           AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                           AND acao_dados.cod_tipo < 4
                    INNER JOIN orcamento.funcao
                            ON funcao.cod_funcao = acao_dados.cod_funcao
                           AND funcao.exercicio  = acao_dados.exercicio
                    INNER JOIN (
                            SELECT acao_dados.cod_acao
                              ,    acao_dados.timestamp_acao_dados
                              ,    coalesce(despesa_capital.valor_capital, 0.00) as valor_capital
                              ,    coalesce(despesa_corrente.valor_corrente, 0.00) as valor_corrente
                              ,    (case when despesa_corrente.ano <> '' then despesa_corrente.ano else despesa_capital.ano end) as ano
                              FROM ppa.acao_dados
                         LEFT JOIN ( SELECT acao_quantidade.ano
                                          , SUM(acao_quantidade.valor) AS valor_corrente
                                          , acao_quantidade.cod_acao
                                          , acao_quantidade.timestamp_acao_dados AS timestamp
                                       FROM ppa.acao_quantidade
                                 INNER JOIN ppa.acao_dados
                                         ON acao_quantidade.cod_acao = acao_dados.cod_acao
                                        AND acao_quantidade.timestamp_acao_dados = acao_dados.timestamp_acao_dados
                                        AND acao_dados.cod_natureza = 1
                                 INNER JOIN ppa.acao
                                         ON acao.cod_acao = acao_dados.cod_acao
                                 INNER JOIN ppa.programa
                                         ON programa.cod_programa = acao.cod_programa
                                 INNER JOIN ppa.programa_dados
                                         ON programa_dados.cod_programa = programa.cod_programa
                                        AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                                 INNER JOIN ppa.programa_setorial
                                         ON programa_setorial.cod_setorial = programa.cod_setorial
                                 INNER JOIN ppa.macro_objetivo
                                         ON macro_objetivo.cod_macro = programa_setorial.cod_macro
                                 INNER JOIN ppa.ppa
                                         ON ppa.cod_ppa = macro_objetivo.cod_ppa
                                  LEFT JOIN ppa.ppa_precisao
                                         ON ppa_precisao.cod_ppa = ppa.cod_ppa
                                   GROUP BY acao_quantidade.cod_acao
                                          , acao_quantidade.timestamp_acao_dados
                                          , acao_quantidade.ano
                                          , ppa_precisao.cod_ppa
                                   ) AS despesa_corrente
                                ON despesa_corrente.cod_acao  = acao_dados.cod_acao
                               AND despesa_corrente.timestamp = acao_dados.timestamp_acao_dados
                         LEFT JOIN ( SELECT acao_quantidade.ano
                                          , SUM(acao_quantidade.valor) AS valor_capital
                                          , acao_quantidade.cod_acao
                                          , acao_quantidade.timestamp_acao_dados AS timestamp
                                       FROM ppa.acao_quantidade
                                 INNER JOIN ppa.acao_dados
                                         ON acao_quantidade.cod_acao = acao_dados.cod_acao
                                        AND acao_quantidade.timestamp_acao_dados = acao_dados.timestamp_acao_dados
                                        AND acao_dados.cod_natureza = 2
                                 INNER JOIN ppa.acao
                                         ON acao.cod_acao = acao_dados.cod_acao
                                 INNER JOIN ppa.programa
                                         ON programa.cod_programa = acao.cod_programa
                                 INNER JOIN ppa.programa_dados
                                         ON programa_dados.cod_programa = programa.cod_programa
                                        AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                                 INNER JOIN ppa.programa_setorial
                                         ON programa_setorial.cod_setorial = programa.cod_setorial
                                 INNER JOIN ppa.macro_objetivo
                                         ON macro_objetivo.cod_macro = programa_setorial.cod_macro
                                 INNER JOIN ppa.ppa
                                         ON ppa.cod_ppa = macro_objetivo.cod_ppa
                                  LEFT JOIN ppa.ppa_precisao
                                         ON ppa_precisao.cod_ppa = ppa.cod_ppa
                                   GROUP BY acao_quantidade.cod_acao
                                          , acao_quantidade.timestamp_acao_dados
                                          , acao_quantidade.ano
                                          , ppa_precisao.cod_ppa
                                   ) AS despesa_capital
                                ON despesa_capital.cod_acao  = acao_dados.cod_acao
                               AND despesa_capital.timestamp = acao_dados.timestamp_acao_dados
                        INNER JOIN ppa.acao
                                ON acao.cod_acao = acao_dados.cod_acao
                               AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
                          ORDER BY acao_dados.cod_acao
                                 , ano	
                            ) as despesa
                          ON despesa.cod_acao = acao_dados.cod_acao
                         AND despesa.timestamp_acao_dados = acao_dados.timestamp_acao_dados
                       WHERE macro_objetivo.cod_ppa = :cod_ppa
                       AND  acao_dados.cod_funcao = :cod_funcao
                         GROUP BY funcao.cod_funcao
                              ,  funcao.descricao
                              ,  despesa.ano
                         ORDER BY funcao.cod_funcao")
        );

        list($cod_ppa, $cod_funcao) = $params;
        $query->bindValue('cod_ppa', $cod_ppa);
        $query->bindValue('cod_funcao', $cod_funcao);
        $query->execute();

        return $query->fetchAll();
    }
}
