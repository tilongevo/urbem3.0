<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Doctrine\ORM;

class ResumoDespesasProgramasReportRepository extends ORM\EntityRepository
{
    /**
     * Teste de uma das querys, do relatorio
     * @param $params
     * @return array
     */
    public function queryRelatorioOne($params)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT acao.cod_acao
                    ,  acao.num_acao
                    ,  acao_dados.titulo
                    ,  produto.descricao	       	
                    ,  (CASE WHEN unidade_medida.simbolo <> '' THEN unidade_medida.simbolo
                             ELSE unidade_medida.nom_unidade 
                        END) AS unidade_medida
                    ,  orgao.nom_orgao AS orgao_executor
                    ,  regiao.nome AS regionalizacao
                    ,  SUM(valores.valor_ano_1) AS valor_ano_1
                    ,  SUM(valores.meta_ano_1) AS meta_ano_1
                    ,  SUM(valores.valor_ano_2) AS valor_ano_2
                    ,  SUM(valores.meta_ano_2) AS meta_ano_2
                    ,  SUM(valores.valor_ano_3) AS valor_ano_3
                    ,  SUM(valores.meta_ano_3) AS meta_ano_3
                    ,  SUM(valores.valor_ano_4) AS valor_ano_4
                    ,  SUM(valores.meta_ano_4) AS meta_ano_4
                    ,  acao_dados.cod_tipo_orcamento
                    ,  acao_dados.valor_estimado
                    ,  acao_dados.meta_estimada
                    ,  tipo_acao.descricao AS tipo_acao
                    ,  acao_periodo.data_inicio
                    ,  acao_periodo.data_termino
                    ,  programa_dados.continuo
                  FROM ppa.acao
            INNER JOIN ppa.acao_dados
                    ON acao_dados.cod_acao		       = acao.cod_acao
                   AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
             LEFT JOIN ppa.acao_periodo
                    ON acao_periodo.cod_acao = acao_dados.cod_acao
                   AND acao_periodo.timestamp_acao_dados = acao_dados.timestamp_acao_dados
            INNER JOIN ppa.produto
                    ON produto.cod_produto = acao_dados.cod_produto
            INNER JOIN ppa.regiao
                    ON regiao.cod_regiao = acao_dados.cod_regiao
            INNER JOIN ppa.tipo_acao
                    ON tipo_acao.cod_tipo = acao_dados.cod_tipo
            INNER JOIN administracao.unidade_medida
                    ON unidade_medida.cod_unidade  = acao_dados.cod_unidade_medida
                   AND unidade_medida.cod_grandeza = acao_dados.cod_grandeza
            INNER JOIN ppa.acao_unidade_executora
                    ON acao_unidade_executora.cod_acao		       = acao_dados.cod_acao
                   AND acao_unidade_executora.timestamp_acao_dados = acao_dados.timestamp_acao_dados
            INNER JOIN orcamento.unidade
                    ON unidade.exercicio   = acao_unidade_executora.exercicio_unidade
                   AND unidade.num_unidade = acao_unidade_executora.num_unidade
                   AND unidade.num_orgao   = acao_unidade_executora.num_orgao
            INNER JOIN orcamento.orgao
                    ON orgao.num_orgao = unidade.num_orgao
                   AND orgao.exercicio = unidade.exercicio
            INNER JOIN (
                        SELECT acao_quantidade.valor AS valor_ano_1
                             , acao_quantidade.quantidade AS meta_ano_1
                             , 0 AS valor_ano_2
                             , 0 AS meta_ano_2
                             , 0 AS valor_ano_3
                             , 0 AS meta_ano_3
                             , 0 AS valor_ano_4
                             , 0 AS meta_ano_4
                             , acao_quantidade.cod_acao
                             , acao_quantidade.timestamp_acao_dados
                          FROM ppa.acao_quantidade
                         WHERE acao_quantidade.ano = '1'
            
                        UNION ALL
            
                        SELECT 0 AS valor_ano_1
                             , 0 AS meta_ano_1
                             , acao_quantidade.valor AS valor_ano_2
                             , acao_quantidade.quantidade AS meta_ano_2
                             , 0 AS valor_ano_3
                             , 0 AS meta_ano_3
                             , 0 AS valor_ano_4
                             , 0 AS meta_ano_4
                             , acao_quantidade.cod_acao
                             , acao_quantidade.timestamp_acao_dados
                          FROM ppa.acao_quantidade
                         WHERE acao_quantidade.ano = '2'
            
                        UNION ALL
            
                        SELECT 0 AS valor_ano_1
                             , 0 AS meta_ano_1
                             , 0 AS valor_ano_2
                             , 0 AS meta_ano_2
                             , acao_quantidade.valor AS valor_ano_3
                             , acao_quantidade.quantidade AS meta_ano_3
                             , 0 AS valor_ano_4
                             , 0 AS meta_ano_4
                             , acao_quantidade.cod_acao
                             , acao_quantidade.timestamp_acao_dados
                          FROM ppa.acao_quantidade
                         WHERE acao_quantidade.ano = '3'
            
                        UNION ALL
            
                        SELECT 0 AS valor_ano_1
                             , 0 AS meta_ano_1
                             , 0 AS valor_ano_2
                             , 0 AS meta_ano_2
                             , 0 AS valor_ano_3
                             , 0 AS meta_ano_3
                             , acao_quantidade.valor AS valor_ano_4
                             , acao_quantidade.quantidade AS meta_ano_4
                             , acao_quantidade.cod_acao
                             , acao_quantidade.timestamp_acao_dados
                          FROM ppa.acao_quantidade
                         WHERE acao_quantidade.ano = '4'
                     ) AS valores
                    ON valores.cod_acao             = acao.cod_acao
                   AND valores.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
            INNER JOIN ppa.programa
                    ON programa.cod_programa = acao.cod_programa
            INNER JOIN ppa.programa_dados
                    ON programa_dados.cod_programa = programa.cod_programa
                   AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                 WHERE acao.ativo = 't'
                   AND programa.cod_programa = :cod_programa
            AND acao_dados.cod_tipo > 3
            
             group by acao.cod_acao 	
                    , acao.num_acao 	
                    , acao_dados.titulo 
                    , produto.descricao 
                    , unidade_medida.nom_unidade 
                    , unidade_medida.simbolo 
                    , orgao.nom_orgao 
                    , regiao.nome 
                    , acao_dados.cod_tipo_orcamento 
                    , acao_dados.valor_estimado 
                    , acao_dados.meta_estimada 
                    , tipo_acao.descricao 
                    , acao_periodo.data_inicio 
                    , acao_periodo.data_termino 
                    , programa_dados.continuo ")
        );

        list($codPrograma) = $params;
        $query->bindValue('cod_programa', $codPrograma);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Teste de uma das querys, do relatorio
     * @param $params
     * @return array
     */
    public function queryRelatorioTwo($params)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT macro_objetivo.cod_macro
                        ,  macro_objetivo.descricao AS descricao_macro
                        ,  programa_setorial.cod_setorial
                        ,  programa_setorial.descricao AS descricao_setorial
                        ,  programa.cod_programa
                        ,  programa.num_programa
                        ,  programa_dados.cod_tipo_programa
                        ,  tipo_programa.descricao AS descricao_tipo_programa
                        ,  programa_dados.identificacao
                        FROM ppa.ppa
                        INNER JOIN ppa.macro_objetivo
                        ON macro_objetivo.cod_ppa = ppa.cod_ppa
                        INNER JOIN ppa.programa_setorial
                        ON programa_setorial.cod_macro = macro_objetivo.cod_macro
                        INNER JOIN ppa.programa
                        ON programa.cod_setorial = programa_setorial.cod_setorial
                        INNER JOIN ppa.programa_dados
                        ON programa_dados.cod_programa             = programa.cod_programa
                        AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                        INNER JOIN ppa.tipo_programa
                        ON tipo_programa.cod_tipo_programa = programa_dados.cod_tipo_programa
                        WHERE ppa.cod_ppa = :cod_ppa
                        AND programa.ativo = 't'
                        AND programa.num_programa = :num_programa
                        AND EXISTS (    SELECT 1
                        FROM ppa.acao
                        INNER JOIN ppa.acao_dados
                        ON acao_dados.cod_acao             = acao.cod_acao
                        AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                        WHERE acao.cod_programa = programa.cod_programa
                        AND acao_dados.cod_tipo > 3)
                        ORDER BY programa_dados.cod_tipo_programa
                        ,  macro_objetivo.cod_macro
                        ,  programa_setorial.cod_setorial
                        ,  programa.cod_programa
                        ,  programa_dados.identificacao
                    ")
        );

        list($numPrograma,$codPpa) = $params;
        $query->bindValue('num_programa', $numPrograma);
        $query->bindValue('cod_ppa', $codPpa);
        $query->execute();
        return $query->fetchAll();
    }
}
