<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Doctrine\ORM;

class DespesaFonteRecursoReportRepository extends ORM\EntityRepository
{

    /**
     * Teste da query, do relatório Despesa fonte recurso
     * @param array $params
     * @return array
     */
    public function queryRelatorio(array $params)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT ppa.cod_ppa
                          , ppa.ano_inicio
                          , ppa.ano_final
                          , (ppa.ano_inicio::INTEGER + acao_recurso.ano::INTEGER - 1) AS ano_recurso
                          , recurso.masc_recurso AS cod_recurso
                          , recurso.nom_recurso
                          , acao_recurso.exercicio_recurso
                          , CASE WHEN (acao_dados.cod_natureza = 1)
                                THEN acao_recurso.valor
                                ELSE 0  
                           END AS valor_corrente
                         , CASE WHEN (acao_dados.cod_natureza = 2)
                                THEN acao_recurso.valor
                                ELSE 0
                           END AS valor_capital
                         , CASE WHEN (acao_dados.cod_natureza IS NULL AND acao_dados.cod_tipo > 3)
                                THEN acao_recurso.valor
                                ELSE 0
                           END AS valor_nao_orcamentaria
                         , acao_dados.cod_tipo
                         , programa_dados.cod_tipo_programa
                         , tipo_programa.descricao AS nom_tipo_programa         
                      FROM ppa.acao
                INNER JOIN ppa.acao_dados
                        ON acao.cod_acao                    = acao_dados.cod_acao
                       AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
                INNER JOIN ppa.acao_recurso  
                        ON acao.cod_acao                    = acao_recurso.cod_acao
                       AND acao.ultimo_timestamp_acao_dados = acao_recurso.timestamp_acao_dados
                INNER JOIN ppa.programa
                        ON acao.cod_programa = programa.cod_programa
                INNER JOIN ppa.programa_dados
                        ON programa.cod_programa                    = programa_dados.cod_programa
                       AND programa.ultimo_timestamp_programa_dados = programa_dados.timestamp_programa_dados
                INNER JOIN ppa.tipo_programa
                        ON programa_dados.cod_tipo_programa = tipo_programa.cod_tipo_programa    
                INNER JOIN ppa.programa_setorial
                        ON programa.cod_setorial = programa_setorial.cod_setorial
                INNER JOIN ppa.macro_objetivo
                        ON programa_setorial.cod_macro = macro_objetivo.cod_macro
                INNER JOIN ppa.ppa
                        ON macro_objetivo.cod_ppa = ppa.cod_ppa
                INNER JOIN ( SELECT exercicio
                                  , masc_recurso
                                  , cod_recurso
                                  , nom_recurso
                               FROM orcamento.recurso(:exercicio1) 
                
                          UNION ALL
                
                             SELECT exercicio
                                  , masc_recurso
                                  , cod_recurso
                                  , nom_recurso
                               FROM orcamento.recurso(:exercicio2)
                
                          UNION ALL
                
                             SELECT exercicio
                                  , masc_recurso
                                  , cod_recurso
                                  , nom_recurso
                               FROM orcamento.recurso(:exercicio3)
                
                          UNION ALL
                
                             SELECT exercicio
                                  , masc_recurso
                                  , cod_recurso
                                  , nom_recurso
                               FROM orcamento.recurso(:exercicio4)
                         ) AS recurso
                        ON recurso.exercicio   = acao_recurso.exercicio_recurso
                       AND recurso.cod_recurso = acao_recurso.cod_recurso
                     WHERE ppa.cod_ppa = :cod_ppa
                ")
        );

        list($exercicio1,$exercicio2,$exercicio3,$exercicio4,$codPpa) = $params;
        $query->bindValue('exercicio1', $exercicio1);
        $query->bindValue('exercicio2', $exercicio2);
        $query->bindValue('exercicio3', $exercicio3);
        $query->bindValue('exercicio4', $exercicio4);
        $query->bindValue('cod_ppa', $codPpa);
        $query->execute();

        return $query->fetchAll();
    }
}
