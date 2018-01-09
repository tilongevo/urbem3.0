<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Doctrine\ORM;

class AcoesNaoOrcamentariasReportRepository extends ORM\EntityRepository
{
    /**
     * Busca os programas por cod_ppa
     * @param $codPpa
     * @return array
     */
    public function findAllTipoAcao()
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("	    
                    SELECT 
                    cod_tipo ,
                    descricao 
                    FROM 
                        ppa.tipo_acao WHERE cod_tipo > 3 ORDER BY cod_tipo
                 ")
        );
        $query->execute();
        return $this->hydrate($query->fetchAll(), 'cod_tipo', 'descricao');
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
        if (!empty($array)) {
            foreach ($array as $orgao) {
                $retorno[$orgao[$chave] .' - '.$orgao[$valor]] = $orgao[$chave];
            }
        }
        return $retorno;
    }

    /**
     * Busca os programas por codigo do ppa.
     * Se não passar o parametro, retorna todos os registros
     *
     * @param null $codPpa
     * @return array
     */
    public function findAllPrograma($codPpa = null)
    {
        $programaRepository = $this->_em->getRepository('CoreBundle:Ppa\Programa');

        $queryBuilder = $programaRepository->createQueryBuilder('p');
        $queryBuilder->innerJoin('CoreBundle:Ppa\ProgramaSetorial', 'ps', 'WITH', 'p.codSetorial = ps.codSetorial');
        $queryBuilder->innerJoin('CoreBundle:Ppa\MacroObjetivo', 'mo', 'WITH', 'ps.codMacro = mo.codMacro');

        if (!empty($codPpa)) {
            $queryBuilder->where('mo.codPpa = :codPpa');
            $queryBuilder->setParameter('codPpa', $codPpa);
        }

        $queryBuilder->orderBy('p.numPrograma', 'ASC');
        $programas = $queryBuilder->getQuery()->getResult();

        $listProgramas = [];
        if (is_array($programas)) {
            foreach ($programas as $programa) {
                $programaDados = $programa->getFkPpaProgramaDados()->filter(
                    function ($entry) use ($programa) {
                        if ($entry->getTimestampProgramaDados() == $programa->getUltimoTimestampProgramaDados()) {
                            return $entry;
                        }
                    }
                )->first();
                $return = str_pad($programa->getNumPrograma(), 4, "0", STR_PAD_LEFT);
                if ($programaDados) {
                    $return .= ' - ' . $programaDados->getIdentificacao();
                }
                $listProgramas[$programa->getCodPrograma()] = $return;
            }
        }

        return $listProgramas;
    }


    /**
     * Teste relatorio
     * @param $params
     * @return array
     */
    public function testQueryOneRelatorio($params)
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
             AND acao_dados.cod_tipo = :cod_tipo
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
                    , programa_dados.continuo;
                ")
        );

        list($codPrograma,$codTipo) = $params;
        $query->bindValue('cod_programa', $codPrograma);
        $query->bindValue('cod_tipo', $codTipo);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Teste relatorio
     * @param $params
     * @return array
     */
    public function testQueryTwoRelatorio($params)
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
                            ON programa_dados.cod_programa = programa.cod_programa
                            AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                            INNER JOIN ppa.tipo_programa
                            ON tipo_programa.cod_tipo_programa = programa_dados.cod_tipo_programa
                            WHERE ppa.cod_ppa = :cod_ppa
                            AND programa.ativo = 't'
                            AND programa.num_programa = :cod_programa
                            AND EXISTS (
                            SELECT 1
                            FROM ppa.acao
                            INNER JOIN ppa.acao_dados
                            ON acao_dados.cod_acao = acao.cod_acao
                            AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                            WHERE acao.cod_programa = programa.cod_programa
                            AND acao_dados.cod_tipo > :cod_tipo)
                            ORDER BY programa_dados.cod_tipo_programa
                            ,  macro_objetivo.cod_macro
                            ,  programa_setorial.cod_setorial
                            ,  programa.cod_programa
                            ,  programa_dados.identificacao ;

            ")
        );

        list($codPrograma,$codTipo,$codPpa) = $params;
        $query->bindValue('cod_programa', $codPrograma);
        $query->bindValue('cod_tipo', $codTipo);
        $query->bindValue('cod_ppa', $codPpa);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Teste relatorio
     * @param $params
     * @return array
     */
    public function testQueryThreeRelatorio($params)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT tipo_acao.descricao AS tipo_acao
                    , SUM(valores.valor1) AS valor_ano_1
                    , SUM(valores.valor2) AS valor_ano_2
                    , SUM(valores.valor3) AS valor_ano_3
                    , SUM(valores.valor4) AS valor_ano_4
                    FROM ppa.acao
                    INNER JOIN ppa.acao_dados
                    ON acao_dados.cod_acao       = acao.cod_acao
                    AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                    LEFT JOIN ppa.acao_periodo
                    ON acao_periodo.cod_acao = acao_dados.cod_acao
                    AND acao_periodo.timestamp_acao_dados = acao_dados.timestamp_acao_dados
                    LEFT JOIN ppa.produto
                    ON produto.cod_produto = acao_dados.cod_produto
                    INNER JOIN ppa.regiao
                    ON regiao.cod_regiao = acao_dados.cod_regiao
                    INNER JOIN ppa.tipo_acao
                    ON tipo_acao.cod_tipo = acao_dados.cod_tipo
                    INNER JOIN administracao.unidade_medida
                    ON unidade_medida.cod_unidade  = acao_dados.cod_unidade_medida
                    AND unidade_medida.cod_grandeza = acao_dados.cod_grandeza
                    INNER JOIN ppa.acao_unidade_executora
                    ON acao_unidade_executora.cod_acao       = acao_dados.cod_acao
                    AND acao_unidade_executora.timestamp_acao_dados = acao_dados.timestamp_acao_dados
                    INNER JOIN orcamento.unidade
                    ON unidade.exercicio   = acao_unidade_executora.exercicio_unidade
                    AND unidade.num_unidade = acao_unidade_executora.num_unidade
                    AND unidade.num_orgao   = acao_unidade_executora.num_orgao
                    INNER JOIN ( SELECT SUM(valores_ano.valor1) AS valor1
                    , SUM(valores_ano.valor2) AS valor2
                    , SUM(valores_ano.valor3) AS valor3
                    , SUM(valores_ano.valor4) AS valor4
                    , valores_ano.cod_acao
                    , valores_ano.timestamp_acao_dados
                    FROM ( SELECT acao_quantidade.valor AS valor1
                    , 0.00 AS valor2
                    , 0.00 AS valor3
                    , 0.00 AS valor4
                    , acao_quantidade.quantidade
                    , acao_quantidade.cod_acao
                    , acao_quantidade.timestamp_acao_dados
                    FROM ppa.acao_quantidade
                    WHERE acao_quantidade.ano = '1'
                    
                    UNION ALL
                    
                    SELECT 0.00 AS valor1
                    , acao_quantidade.valor AS valor2
                    , 0.00 AS valor3
                    , 0.00 AS valor4
                    , acao_quantidade.quantidade
                    , acao_quantidade.cod_acao
                    , acao_quantidade.timestamp_acao_dados
                    FROM ppa.acao_quantidade
                    WHERE acao_quantidade.ano = '2'
                    
                    UNION ALL
                    
                    SELECT 0.00 AS valor1
                    , 0.00 AS valor2
                    , acao_quantidade.valor AS valor3
                    , 0.00 AS valor4
                    , acao_quantidade.quantidade
                    , acao_quantidade.cod_acao
                    , acao_quantidade.timestamp_acao_dados
                    FROM ppa.acao_quantidade
                    WHERE acao_quantidade.ano = '3'
                    
                    UNION ALL
                    
                    SELECT 0.00 AS valor1
                    , 0.00 AS valor2
                    , 0.00 AS valor3
                    , acao_quantidade.valor AS valor4
                    , acao_quantidade.quantidade
                    , acao_quantidade.cod_acao
                    , acao_quantidade.timestamp_acao_dados
                    FROM ppa.acao_quantidade
                    WHERE acao_quantidade.ano = '4'
                    ) AS valores_ano
                    GROUP BY valores_ano.cod_acao
                    , valores_ano.timestamp_acao_dados
                    ) AS valores
                    ON valores.cod_acao             = acao.cod_acao
                    AND valores.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
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
                    WHERE acao.ativo = 't'
                    AND acao_dados.cod_tipo = :cod_tipo
                    AND programa.num_programa = :cod_programa
                    GROUP BY tipo_acao.descricao;
            ")
        );

        list($codPrograma,$codTipo) = $params;
        $query->bindValue('cod_programa', $codPrograma);
        $query->bindValue('cod_tipo', $codTipo);
        $query->execute();

        return $query->fetchAll();
    }
}
