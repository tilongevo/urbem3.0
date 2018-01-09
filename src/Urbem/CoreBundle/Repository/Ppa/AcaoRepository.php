<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Urbem\CoreBundle\Repository\AbstractRepository;

class AcaoRepository extends AbstractRepository
{
    public function verificaAcaoExistente($numAcao, $codPpa)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf(
                "SELECT *
	              FROM (
	                SELECT LPAD(acao.num_acao::VARCHAR,4,'0') AS num_acao
	                     , LPAD(acao.cod_acao::VARCHAR,4,'0') AS cod_acao
	                     , acao_dados.descricao
	                     , acao_dados.titulo
	                     , programa.num_programa
	                     , programa_dados.identificacao
	                     , programa_dados.objetivo
	                     , programa_dados.diagnostico
	                     , programa_dados.diretriz
	                     , programa_dados.publico_alvo
	                     , programa_dados.continuo
	                     , to_real(SUM(acao_recurso.valor)) AS valor
	                     , acao.ultimo_timestamp_acao_dados
	                     , ppa.cod_ppa
	                     , acao_dados.cod_funcao
	                     , acao_dados.cod_subfuncao
	                     , funcao.descricao AS desc_funcao
	                     , subfuncao.descricao AS desc_subfuncao
	                     , acao_dados.cod_tipo
	                     , tipo_acao.descricao as desc_tipo
	                     , '' AS exercicio
	                  FROM ppa.acao
	            INNER JOIN ppa.acao_dados
	                    ON acao.cod_acao = acao_dados.cod_acao
	                   AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
	            INNER JOIN ppa.tipo_acao
	                    ON acao_dados.cod_tipo = tipo_acao.cod_tipo
	             LEFT JOIN orcamento.funcao
	                    ON acao_dados.exercicio = funcao.exercicio
	                   AND acao_dados.cod_funcao = funcao.cod_funcao
	             LEFT JOIN orcamento.subfuncao
	                    ON acao_dados.exercicio = subfuncao.exercicio
	                   AND acao_dados.cod_subfuncao = subfuncao.cod_subfuncao
	             LEFT JOIN ppa.acao_recurso
	                    ON acao.cod_acao = acao_recurso.cod_acao
	                   AND acao.ultimo_timestamp_acao_dados = acao_recurso.timestamp_acao_dados
	            INNER JOIN ppa.programa
	                    ON acao.cod_programa = programa.cod_programa
	            INNER JOIN ppa.programa_dados
	                    ON programa_dados.cod_programa = programa.cod_programa
	                   AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
	            INNER JOIN ppa.programa_setorial
	                    ON programa.cod_setorial = programa_setorial.cod_setorial
	            INNER JOIN ppa.macro_objetivo
	                    ON macro_objetivo.cod_macro = programa_setorial.cod_macro
	            INNER JOIN ppa.ppa
	                    ON macro_objetivo.cod_ppa = ppa.cod_ppa
	        GROUP BY acao.num_acao
	                          , acao.cod_acao
	                          , acao_dados.descricao
	                          , acao_dados.titulo
	                          , programa.num_programa
	                          , programa_dados.identificacao
	                          , programa_dados.objetivo
	                          , programa_dados.diagnostico
	                          , programa_dados.diretriz
	                          , programa_dados.publico_alvo
	                          , programa_dados.continuo
	                          , acao.ultimo_timestamp_acao_dados
	                          , ppa.cod_ppa
	                          , acao_dados.cod_funcao
	                          , acao_dados.cod_subfuncao
	                          , funcao.descricao
	                          , subfuncao.descricao
	                          , acao_dados.cod_tipo
	                          , tipo_acao.descricao
	                      UNION

	                SELECT LPAD(pao.num_pao::VARCHAR,4,'0') AS num_acao
	                     , LPAD(pao.num_pao::VARCHAR,4,'0') AS cod_acao
	                     , pao.nom_pao AS descricao
	                     , pao.nom_pao AS titulo
	                     , null AS num_programa
	                     , '' AS identificacao
	                     , '' AS objetivo
	                     , '' AS diagnostico
	                     , '' AS diretriz
	                     , '' AS publico_alvo
	                     , null AS continuo
	                     , TO_REAL(0) AS valor
	                     , null AS ultimo_timestamp_acao_dados
	                     , null AS cod_ppa
	                     , null AS cod_funcao
	                     , null AS cod_subfuncao
	                     , '' AS desc_funcao
	                     , '' AS desc_subfuncao
	                     , (SELECT orcamento.fn_consulta_tipo_pao(pao.exercicio,pao.num_pao)) AS cod_tipo
	                     , CASE WHEN ( (SELECT orcamento.fn_consulta_tipo_pao(pao.exercicio,pao.num_pao)) = 1 )
	                            THEN 'Projeto'                                                                                                               WHEN ( (SELECT orcamento.fn_consulta_tipo_pao(pao.exercicio,pao.num_pao)) = 2 )
	                            THEN 'Atividade'
	                            WHEN ( (SELECT orcamento.fn_consulta_tipo_pao(pao.exercicio,pao.num_pao)) = 3 )
	                            THEN 'Operações Especiais'
	                            WHEN ( (SELECT orcamento.fn_consulta_tipo_pao(pao.exercicio,pao.num_pao)) = 4 )
	                            THEN 'Não Orçamentária'
	                       END AS desc_tipo
	                     , pao.exercicio
	                  FROM orcamento.pao
	                 INNER JOIN ( SELECT num_pao
	                                   , MAX(exercicio) AS exercicio
	                                FROM orcamento.pao
	                            GROUP BY num_pao
	                            ) AS max_pao
	                         ON max_pao.num_pao   = pao.num_pao
	                        AND max_pao.exercicio = pao.exercicio
	                      WHERE NOT EXISTS ( SELECT 1
	                                           FROM orcamento.pao_ppa_acao
	                                          WHERE pao.exercicio = pao_ppa_acao.exercicio
	                                            AND pao.num_pao   = pao_ppa_acao.num_pao)
	                    ) AS tabela  WHERE  num_acao::INTEGER = :numAcao AND cod_ppa = :codPpa"
            )
        );
        $query->bindValue('numAcao', $numAcao);
        $query->bindValue('codPpa', $codPpa);
        $query->execute();
        return $query->fetchAll();
    }

    public function verificaMetasFisicasRealizadas($ano, $exercicio)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf(
                "SELECT  ano1.cod_acao
                       , LPAD(acao.num_acao::TEXT, 4, '0') AS num_acao
                       , ano1.timestamp_acao_dados
                       , recurso.masc_recurso AS cod_recurso_mascarado
                       , ano1.cod_recurso
                       , recurso.nom_recurso
                       , recurso.masc_recurso||' - '||recurso.nom_recurso AS nom_cod_recurso
                       , ano1.exercicio_recurso AS ano1
                       , COALESCE(qtd_ano1.quantidade, 0.00) AS ano1_qtd
                       , COALESCE(ano1.valor, 0.00) AS ano1_valor
                       , COALESCE(realizada_1.valor, 0.00) AS ano1_realizada
                       , realizada_1.justificativa AS ano1_justificativa
                       , ano2.exercicio_recurso AS ano2
                       , COALESCE(qtd_ano2.quantidade, 0.00) AS ano2_qtd
                       , COALESCE(ano2.valor, 0.00) AS ano2_valor
                       , COALESCE(realizada_2.valor, 0.00) AS ano2_realizada
                       , realizada_2.justificativa AS ano2_justificativa
                       , ano3.exercicio_recurso AS ano3
                       , COALESCE(qtd_ano3.quantidade, 0.00) AS ano3_qtd
                       , COALESCE(ano3.valor, 0.00) AS ano3_valor
                       , COALESCE(realizada_3.valor, 0.00) AS ano3_realizada
                       , realizada_3.justificativa AS ano3_justificativa
                       , ano4.exercicio_recurso AS ano4
                       , COALESCE(qtd_ano4.quantidade, 0.00) AS ano4_qtd
                       , COALESCE(ano4.valor, 0.00) AS ano4_valor
                       , COALESCE(realizada_4.valor, 0.00) AS ano4_realizada
                       , realizada_4.justificativa AS ano4_justificativa
                       , COALESCE(qtd_ano1.quantidade, 0.00) + COALESCE(qtd_ano2.quantidade, 0.00) + COALESCE(qtd_ano3.quantidade, 0.00) + COALESCE(qtd_ano4.quantidade, 0.00) as total_qtd
                       , COALESCE(ano1.valor, 0.00) + COALESCE(ano2.valor, 0.00) + COALESCE(ano3.valor, 0.00) + COALESCE(ano4.valor, 0.00) as total_valor
                       , ppa.cod_ppa
                       , ppa.cod_ppa||' - '||ppa.ano_inicio||' a '||ppa.ano_final AS nom_ppa
                  FROM ppa.acao_recurso AS ano1
                  INNER JOIN orcamento.recurso(:exercicio) AS recurso
                          ON ano1.cod_recurso   = recurso.cod_recurso
                   LEFT JOIN ppa.acao_recurso AS ano2
                          ON ano2.ano = '1'
                         AND ano1.cod_acao             = ano2.cod_acao
                         AND ano1.timestamp_acao_dados = ano2.timestamp_acao_dados
                         AND ano1.cod_recurso          = ano2.cod_recurso
                   LEFT JOIN ppa.acao_recurso AS ano3
                          ON ano3.ano = '2'
                         AND ano1.cod_acao             = ano3.cod_acao
                         AND ano1.timestamp_acao_dados = ano3.timestamp_acao_dados
                         AND ano1.cod_recurso          = ano3.cod_recurso
                   LEFT JOIN ppa.acao_recurso AS ano4
                          ON ano4.ano = '4'
                         AND ano1.cod_acao             = ano4.cod_acao
                         AND ano1.timestamp_acao_dados = ano4.timestamp_acao_dados
                         AND ano1.cod_recurso          = ano4.cod_recurso
                   LEFT JOIN ppa.acao_quantidade as qtd_ano1
                          ON qtd_ano1.ano                  = ano1.ano
                         AND qtd_ano1.cod_acao             = ano1.cod_acao
                         AND qtd_ano1.timestamp_acao_dados = ano1.timestamp_acao_dados
                         AND qtd_ano1.cod_recurso          = ano1.cod_recurso
                   LEFT JOIN ppa.acao_quantidade as qtd_ano2
                          ON qtd_ano2.ano                  = ano2.ano
                         AND qtd_ano2.cod_acao             = ano2.cod_acao
                         AND qtd_ano2.timestamp_acao_dados = ano2.timestamp_acao_dados
                         AND qtd_ano2.cod_recurso          = ano2.cod_recurso
                   LEFT JOIN ppa.acao_quantidade as qtd_ano3
                          ON qtd_ano3.ano                  = ano3.ano
                         AND qtd_ano3.cod_acao             = ano3.cod_acao
                         AND qtd_ano3.timestamp_acao_dados = ano3.timestamp_acao_dados
                         AND qtd_ano3.cod_recurso          = ano3.cod_recurso
                   LEFT JOIN ppa.acao_quantidade as qtd_ano4
                          ON qtd_ano4.ano                  = ano4.ano
                         AND qtd_ano4.cod_acao             = ano4.cod_acao
                         AND qtd_ano4.timestamp_acao_dados = ano4.timestamp_acao_dados
                         AND qtd_ano4.cod_recurso          = ano4.cod_recurso

                  INNER JOIN ppa.acao
                          ON acao.cod_acao = ano1.cod_acao
                         AND acao.ultimo_timestamp_acao_dados = ano1.timestamp_acao_dados
                  INNER JOIN ppa.acao_dados
                          ON acao.cod_acao = acao_dados.cod_acao
                         AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
                  INNER JOIN ppa.tipo_acao
                          ON acao_dados.cod_tipo = tipo_acao.cod_tipo
                   LEFT JOIN orcamento.funcao
                          ON acao_dados.exercicio = funcao.exercicio
                         AND acao_dados.cod_funcao = funcao.cod_funcao
                   LEFT JOIN orcamento.subfuncao
                          ON acao_dados.exercicio = subfuncao.exercicio
                         AND acao_dados.cod_subfuncao = subfuncao.cod_subfuncao
                   LEFT JOIN ppa.acao_recurso
                          ON acao.cod_acao = acao_recurso.cod_acao
                         AND acao.ultimo_timestamp_acao_dados = acao_recurso.timestamp_acao_dados
                  INNER JOIN ppa.programa
                          ON acao.cod_programa = programa.cod_programa
                  INNER JOIN ppa.programa_dados
                          ON programa_dados.cod_programa = programa.cod_programa
                         AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                  INNER JOIN ppa.programa_setorial
                          ON programa.cod_setorial = programa_setorial.cod_setorial
                  INNER JOIN ppa.macro_objetivo
                          ON macro_objetivo.cod_macro = programa_setorial.cod_macro
                  INNER JOIN ppa.ppa
                          ON macro_objetivo.cod_ppa = ppa.cod_ppa

                   LEFT JOIN ppa.acao_meta_fisica_realizada AS realizada_1
                          ON realizada_1.cod_acao             = ano1.cod_acao
                         AND realizada_1.timestamp_acao_dados = ano1.timestamp_acao_dados
                         AND realizada_1.cod_recurso          = ano1.cod_recurso
                         AND realizada_1.exercicio_recurso    = ano1.exercicio_recurso
                         AND realizada_1.ano                  = ano1.ano
                   LEFT JOIN ppa.acao_meta_fisica_realizada AS realizada_2
                          ON realizada_2.cod_acao             = ano2.cod_acao
                         AND realizada_2.timestamp_acao_dados = ano2.timestamp_acao_dados
                         AND realizada_2.cod_recurso          = ano2.cod_recurso
                         AND realizada_2.exercicio_recurso    = ano2.exercicio_recurso
                         AND realizada_2.ano                  = ano2.ano
                   LEFT JOIN ppa.acao_meta_fisica_realizada AS realizada_3
                          ON realizada_3.cod_acao             = ano3.cod_acao
                         AND realizada_3.timestamp_acao_dados = ano3.timestamp_acao_dados
                         AND realizada_3.cod_recurso          = ano3.cod_recurso
                         AND realizada_3.exercicio_recurso    = ano3.exercicio_recurso
                         AND realizada_3.ano                  = ano3.ano
                   LEFT JOIN ppa.acao_meta_fisica_realizada AS realizada_4
                          ON realizada_4.cod_acao             = ano4.cod_acao
                         AND realizada_4.timestamp_acao_dados = ano4.timestamp_acao_dados
                         AND realizada_4.cod_recurso          = ano4.cod_recurso
                         AND realizada_4.exercicio_recurso    = ano4.exercicio_recurso
                         AND realizada_4.ano                  = ano4.ano

                   WHERE ano1.ano = :ano
                     AND :exercicio::INTEGER BETWEEN ppa.ano_inicio::INTEGER AND ppa.ano_final::INTEGER
                     AND ano1.timestamp_acao_dados = ( SELECT MAX(timestamp_acao_dados)
                                                         FROM ppa.acao_recurso AS AR
                                                        WHERE AR.cod_acao = ano1.cod_acao
                                                          AND AR.cod_recurso = ano1.cod_recurso
                                                          AND AR.exercicio_recurso = ano1.exercicio_recurso
                                                          AND AR.ano = ano1.ano )
                  GROUP BY ano1.cod_acao
                        , acao.num_acao
                        , ano1.timestamp_acao_dados
                        , recurso.masc_recurso
                        , ano1.cod_recurso
                        , recurso.nom_recurso
                        , ano1.exercicio_recurso
                        , ano2.exercicio_recurso
                        , ano3.exercicio_recurso
                        , ano4.exercicio_recurso
                        , ano1.valor
                        , ano2.valor
                        , ano3.valor
                        , ano4.valor
                        , qtd_ano1.quantidade
                        , qtd_ano2.quantidade
                        , qtd_ano3.quantidade
                        , qtd_ano4.quantidade
                        , ppa.cod_ppa
                        , realizada_1.valor
                        , realizada_2.valor
                        , realizada_3.valor
                        , realizada_4.valor
                        , realizada_1.justificativa
                        , realizada_2.justificativa
                        , realizada_3.justificativa
                        , realizada_4.justificativa
                  ORDER BY acao.num_acao, ano1.cod_recurso"
            )
        );
        $query->bindValue('ano', (string) $ano);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        return $query->fetchAll();
    }
    
    /**
     * @param int $exercicio
     * @param int $codPpa
     * @param boolean $hmlg
     * @return array
     */
    public function getConfigAcaoDespesa($exercicio = null, $codPpa = null, $hmlg = false)
    {
        $sql = "
        SELECT
            ano_ldo,
            cod_ppa,
            ano
        FROM (
            SELECT
                (CAST(ppa.ano_inicio AS INTEGER) + CAST(ldo.ano AS INTEGER)) - 1 AS ano_ldo,
                ppa.cod_ppa,
                ldo.ano
            FROM
                ldo.ldo
            INNER JOIN
                ppa.ppa
                ON ppa.cod_ppa = ldo.cod_ppa
        ) AS ldo";
        
        $where = [];
        
        if (!is_null($codPpa)) {
            $where['ppa'] = " ldo.cod_ppa = :codPpa";
        }
        if (!is_null($exercicio)) {
            $where['exercicio'] = " ldo.ano_ldo = :exercicio";
        }
        if ($hmlg) {
            $where['hmlg'] = " ldo.fn_verifica_homologacao_ldo(cod_ppa, ano)";
        }
        
        $hasWhere = count($where);
        
        if ($hasWhere) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        
        $query = $this->_em->getConnection()->prepare($sql);
        
        if (isset($where['ppa'])) {
            $query->bindValue(':codPpa', $codPpa, \PDO::PARAM_INT);
        }
        if (isset($where['exercicio'])) {
            $query->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        }
        
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * @param int $codPpa
     * @param int $ano
     * @param array $param
     * @return array
     */
    public function getAcaoDespesas($codPpa, $ano, Array $param = [], $order = null, $count = false, $limit = 0, $offset = 0)
    {
        $where = [];
        
        if (!empty($param['inCodAcao'])) {
            $where[] = 'acao.num_acao >= :inCodAcao';
        }
        if (!empty($param['inCodAcaoFim'])) {
            $where[] = 'acao.num_acao <= :inCodAcaoFim';
        }
        if (!empty($param['inCodRecurso'])) {
            $where[] = 'acao_quantidade_disponivel.cod_recurso = :inCodRecurso';
        }
        if (!empty($param['stTitulo'])) {
            $where[] = "acao_dados.titulo ILIKE :stTitulo";
        }
        if (!empty($param['codPrograma'])) {
            $where[] = 'programa.num_programa = :codPrograma';
        }
        
        $whereStr = "";
        
        if (count($where)) {
            $whereStr .= " AND " . implode(" AND ", $where);
        }
        
        $sql = "
        SELECT
            LPAD(acao.num_acao::varchar,4,0::varchar) AS num_acao,
            acao_dados.cod_acao,
            acao_dados.titulo,
            acao_dados.timestamp_acao_dados AS timestamp,
            acao_validada.ano,
            ppa.cod_ppa
        FROM
            ppa.acao
        INNER JOIN
            ppa.acao_dados
            ON acao.cod_acao = acao_dados.cod_acao
            AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
        INNER JOIN
            ldo.acao_validada
            ON acao_dados.cod_acao = acao_validada.cod_acao
            AND acao_dados.timestamp_acao_dados = acao_validada.timestamp_acao_dados
        INNER JOIN
            ppa.programa
            ON acao.cod_programa = programa.cod_programa
        INNER JOIN
            ppa.programa_setorial
            ON programa.cod_setorial = programa_setorial.cod_setorial
        INNER JOIN
            ppa.macro_objetivo
            ON programa_setorial.cod_macro = macro_objetivo.cod_macro
        INNER JOIN
            ppa.ppa
            ON macro_objetivo.cod_ppa = ppa.cod_ppa
        --join para os totais de quantidades
        LEFT JOIN (
            SELECT
                acao_quantidade.cod_acao,
                acao_quantidade.timestamp_acao_dados,
                (SUM(acao_quantidade.quantidade) - SUM(COALESCE(acao_validada.quantidade,0))) AS quantidade,
                acao_quantidade.cod_recurso
            FROM
                ppa.acao_quantidade
            LEFT JOIN 
                ldo.acao_validada
                ON acao_quantidade.cod_acao = acao_validada.cod_acao
                AND acao_quantidade.ano = acao_validada.ano
                AND acao_quantidade.timestamp_acao_dados = acao_validada.timestamp_acao_dados
                AND acao_validada.ano::integer <> :ano
            GROUP BY 
                acao_quantidade.cod_acao,
                acao_quantidade.timestamp_acao_dados,
                acao_quantidade.cod_recurso
        ) AS acao_quantidade_disponivel
            ON acao_dados.cod_acao = acao_quantidade_disponivel.cod_acao
            AND acao_dados.timestamp_acao_dados = acao_quantidade_disponivel.timestamp_acao_dados
        WHERE
            ppa.cod_ppa = :codPpa
            AND acao_validada.ano::integer = :ano
            AND ppa.fn_verifica_homologacao(ppa.cod_ppa)
            ".$whereStr."
        GROUP BY
            acao_dados.cod_acao,
            acao.num_acao,
            acao_dados.titulo,
            acao_dados.timestamp_acao_dados,
            acao_validada.ano,
            ppa.cod_ppa
        ";
        
        if (!empty($order)) {
            $sql .= "ORDER BY ".$order;
        }
        
        if (!$count && $limit > 0 && $offset >= 0) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        
        if ($count) {
            $sql = "
            SELECT COUNT(*) as total FROM
            (".$sql.") as tabela
            ";
        }
        
        $query = $this->_em->getConnection()->prepare($sql);
        
        $query->bindValue(":ano", $ano, \PDO::PARAM_STR);
        $query->bindValue(":codPpa", $codPpa, \PDO::PARAM_INT);
        
        if (!empty($param['inCodAcao'])) {
            $query->bindValue(":inCodAcao", $param['inCodAcao'], \PDO::PARAM_INT);
        }
        if (!empty($param['inCodAcaoFim'])) {
            $query->bindValue(":inCodAcaoFim", $param['inCodAcaoFim'], \PDO::PARAM_INT);
        }
        if (!empty($param['inCodRecurso'])) {
            $query->bindValue(":inCodRecurso", $param['inCodRecurso'], \PDO::PARAM_INT);
        }
        if (!empty($param['stTitulo'])) {
            $query->bindValue(":stTitulo", '%'.$param['stTitulo'].'%', \PDO::PARAM_STR);
        }
        if (!empty($param['codPrograma'])) {
            $query->bindValue(":codPrograma", $param['codPrograma'], \PDO::PARAM_INT);
        }
        
        $query->execute();
        
        if ($count) {
            return $query->fetch(\PDO::FETCH_ASSOC);
        } else {
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * @param int $exercicio
     * @param int $codAcao
     * @param int $ano
     * @param int $codRecurso
     * @return array
     */
    public function recuperaConfigDespesa($exercicio, $codAcao, $ano = 0, $codRecurso = 0)
    {
        $where = [];
        $where[] = 'acao.cod_acao = :codAcao';
        
        if (intval($ano)) {
            $where[] = 'acao_quantidade.ano::INTEGER = :ano';
        }
        if (intval($codRecurso)) {
            $where[] = 'acao_recurso.cod_recurso = :codRecurso';
        }
        
        $whereStr = " WHERE ".implode(" AND ", $where);
        
        $sql = "
        SELECT 
            LPAD(acao.num_acao::VARCHAR,4,'0') AS num_acao,
            LPAD(acao.cod_acao::VARCHAR,4,'0') AS cod_acao,
            ppa.cod_ppa,
            acao.ultimo_timestamp_acao_dados,
            LPAD(programa.cod_programa::VARCHAR,4,'0') AS cod_programa,
            LPAD(programa.num_programa::VARCHAR,4,'0') AS num_programa,
            programa_dados.identificacao AS nom_programa,
            programa_dados.cod_tipo_programa,
            programa_setorial.cod_setorial,
            macro_objetivo.cod_macro,
            acao_dados.titulo,
            acao_dados.descricao,
            acao_dados.finalidade,
            acao_dados.detalhamento,
            acao_dados.cod_forma,
            acao_dados.cod_tipo,
            acao_dados.cod_natureza,
            regiao.cod_regiao,
            regiao.descricao AS nom_regiao,
            produto.cod_produto,
            produto.descricao AS nom_produto,
            acao_norma.cod_norma,
            norma.nom_norma,
            acao_dados.cod_tipo_orcamento,
            funcao.cod_funcao,
            funcao.descricao AS nom_funcao,
            subfuncao.cod_subfuncao,
            subfuncao.descricao AS nom_subfuncao,
            acao_dados.cod_unidade_medida,
            acao_dados.cod_grandeza,
            acao_dados.valor_estimado,
            acao_dados.meta_estimada,
            /*LPAD(acao_unidade_executora.num_orgao,2,0) AS num_orgao,
            LPAD(acao_unidade_executora.num_unidade,2,0) AS num_unidade*/
            LPAD(
                acao_unidade_executora.num_orgao::VARCHAR,
                length(
                    orcamento.fn_masc_orgao(
                        split_part(acao.ultimo_timestamp_acao_dados::VARCHAR, '-', 1)
                    )
                ),'0'
            ) AS num_orgao,
            LPAD(
                acao_unidade_executora.num_unidade::VARCHAR,
                length(
                    orcamento.fn_masc_unidade(
                        split_part(acao.ultimo_timestamp_acao_dados::VARCHAR, '-', 1)
                    )
                ), '0'
            ) AS num_unidade,
            tipo_acao.descricao AS nom_tipo_acao,
            SUM(acao_recurso.valor) AS valor_acao,
            TO_CHAR(programa_temporario_vigencia.dt_inicial, 'dd/mm/yyyy') AS dt_inicial,
            TO_CHAR(programa_temporario_vigencia.dt_final, 'dd/mm/yyyy') AS dt_final,
            TO_CHAR(acao_periodo.data_inicio, 'dd/mm/yyyy') AS dt_inicial_acao,
            TO_CHAR(acao_periodo.data_termino, 'dd/mm/yyyy') AS dt_final_acao,
            programa_dados.continuo,
            pao_ppa_acao.num_pao,
            acao_quantidade.ano
        FROM 
            ppa.acao
        INNER JOIN 
            ppa.programa
            ON acao.cod_programa = programa.cod_programa
        INNER JOIN
            ppa.programa_dados
            ON programa.cod_programa = programa_dados.cod_programa
            AND programa.ultimo_timestamp_programa_dados = programa_dados.timestamp_programa_dados
        INNER JOIN 
            ppa.programa_setorial
            ON programa.cod_setorial = programa_setorial.cod_setorial
        INNER JOIN
            ppa.macro_objetivo
            ON programa_setorial.cod_macro = macro_objetivo.cod_macro
        INNER JOIN
            ppa.ppa
            ON macro_objetivo.cod_ppa = ppa.cod_ppa
        INNER JOIN
            ppa.acao_dados
            ON acao.cod_acao = acao_dados.cod_acao
            AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
        INNER JOIN
            ppa.regiao
            ON acao_dados.cod_regiao = regiao.cod_regiao
        LEFT JOIN
            ppa.produto
            ON acao_dados.cod_produto = produto.cod_produto
        INNER JOIN
            ppa.tipo_acao
            ON tipo_acao.cod_tipo = acao_dados.cod_tipo
        LEFT JOIN
            ppa.acao_norma
            ON acao.cod_acao = acao_norma.cod_acao
            AND acao.ultimo_timestamp_acao_dados = acao_norma.timestamp_acao_dados
        LEFT JOIN
            normas.norma
            ON acao_norma.cod_norma = norma.cod_norma
        LEFT JOIN
            orcamento.funcao
            ON acao_dados.exercicio  = funcao.exercicio
            AND acao_dados.cod_funcao = funcao.cod_funcao
        LEFT JOIN
            orcamento.subfuncao
            ON acao_dados.exercicio     = subfuncao.exercicio
            AND acao_dados.cod_subfuncao = subfuncao.cod_subfuncao
        INNER JOIN
            ppa.acao_unidade_executora
            ON acao_dados.cod_acao             = acao_unidade_executora.cod_acao
            AND acao_dados.timestamp_acao_dados = acao_unidade_executora.timestamp_acao_dados
        INNER JOIN
            ppa.acao_recurso
            ON acao_recurso.cod_acao             = acao_dados.cod_acao
            AND acao_recurso.timestamp_acao_dados = acao_dados.timestamp_acao_dados
        INNER JOIN 
            ppa.acao_quantidade
            ON acao_quantidade.cod_acao             = acao_recurso.cod_acao
            AND acao_quantidade.timestamp_acao_dados = acao_recurso.timestamp_acao_dados
            AND acao_quantidade.cod_recurso          = acao_recurso.cod_recurso
            AND acao_quantidade.exercicio_recurso    = acao_recurso.exercicio_recurso
            AND acao_quantidade.ano                  = acao_recurso.ano
        LEFT JOIN
            ppa.acao_periodo
            ON acao_periodo.cod_acao = acao_dados.cod_acao
            AND acao_periodo.timestamp_acao_dados = acao_dados.timestamp_acao_dados
        LEFT JOIN ppa.programa_temporario_vigencia
           ON programa_temporario_vigencia.cod_programa             = programa_dados.cod_programa
           AND programa_temporario_vigencia.timestamp_programa_dados = programa_dados.timestamp_programa_dados
        LEFT JOIN orcamento.pao_ppa_acao
           ON pao_ppa_acao.cod_acao  = acao.cod_acao
           AND pao_ppa_acao.exercicio = :exercicio
        ".$whereStr."
        GROUP BY 
            acao.num_acao,
            acao.cod_acao,
            ppa.cod_ppa,
            acao.ultimo_timestamp_acao_dados,
            programa.num_programa,
            programa.cod_programa,
            programa_dados.identificacao,
            programa_dados.cod_tipo_programa,
            programa_setorial.cod_setorial,
            macro_objetivo.cod_macro,
            acao_dados.titulo,
            acao_dados.descricao,
            acao_dados.finalidade,
            acao_dados.detalhamento,
            acao_dados.cod_forma,
            acao_dados.cod_tipo,
            acao_dados.cod_natureza,
            regiao.cod_regiao,
            regiao.descricao,
            produto.cod_produto,
            produto.descricao,
            acao_norma.cod_norma,
            norma.nom_norma,
            acao_dados.cod_tipo_orcamento,
            funcao.cod_funcao,
            funcao.descricao,
            subfuncao.cod_subfuncao,
            subfuncao.descricao,
            acao_dados.cod_unidade_medida,
            acao_dados.cod_grandeza,
            acao_dados.valor_estimado,
            acao_dados.meta_estimada,
            acao_unidade_executora.num_orgao,
            acao_unidade_executora.num_unidade,
            programa_temporario_vigencia.dt_inicial,
            programa_temporario_vigencia.dt_final,
            programa_dados.continuo,
            acao_periodo.data_inicio,
            acao_periodo.data_termino,
            tipo_acao.descricao,
            pao_ppa_acao.num_pao,
            acao_quantidade.ano
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        
        $query->bindValue(":exercicio", $exercicio, \PDO::PARAM_STR);
        $query->bindValue(":codAcao", $codAcao, \PDO::PARAM_INT);
        
        if (intval($ano)) {
            $query->bindValue(":ano", $ano, \PDO::PARAM_INT);
        }
        if (intval($codRecurso)) {
            $query->bindValue(":codRecurso", $codRecurso, \PDO::PARAM_INT);
        }
        
        $query->execute();
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * @param int $exercicio
     * @param int $codAno
     * @param int $codAcao
     * @return mixed
     */
    function recuperaDespesaByAcao($exercicio, $codAno, $codAcao)
    {
        $sql = "
        SELECT
            recurso.masc_recurso AS cod_recurso,
            recurso.nom_recurso,
            SUM(recursos.vl_estimado) AS vl_estimado,
            SUM(recursos.vl_despesa) AS vl_despesa,
            SUM(recursos.vl_estimado) - SUM(recursos.vl_despesa) AS vl_total
	    FROM (
            SELECT
                acao_validada.cod_recurso,
                acao_validada.cod_acao,
                CAST(acao_validada.ano AS INTEGER) AS ano,
                SUM(acao_validada.valor) AS vl_estimado,
                0.00 AS vl_despesa
            FROM
                ldo.acao_validada
	        WHERE
                acao_validada.timestamp_acao_dados = ( SELECT MAX(timestamp_acao_dados)
	        FROM
                ldo.acao_validada AS max_acao_validada
	        WHERE
                max_acao_validada.cod_acao = acao_validada.cod_acao
	            AND max_acao_validada.cod_recurso = acao_validada.cod_recurso
	            AND max_acao_validada.exercicio_recurso = acao_validada.exercicio_recurso
	            AND max_acao_validada.ano = acao_validada.ano )
	        GROUP BY
                acao_validada.cod_recurso,
                acao_validada.cod_acao,
                acao_validada.ano
	        UNION ALL
	        SELECT
                despesa.cod_recurso,
                despesa_acao.cod_acao,
                CAST(despesa.exercicio AS INTEGER) - CAST(ano_inicio AS INTEGER) + 1 AS ano,
                0.00 AS vl_estimado,
                SUM(despesa.vl_original) AS vl_despesa
    	    FROM
                orcamento.despesa
    	    JOIN
                orcamento.despesa_acao
    	        ON despesa_acao.cod_despesa = despesa.cod_despesa
    	        AND despesa_acao.exercicio_despesa = despesa.exercicio
    	    JOIN
                ppa.acao
    	        ON acao.cod_acao = despesa_acao.cod_acao
    	    JOIN
                ppa.programa
    	        ON programa.cod_programa = acao.cod_programa
    	    JOIN
                ppa.programa_setorial
    	        ON programa_setorial.cod_setorial = programa.cod_setorial
    	    JOIN
                ppa.macro_objetivo
    	        ON macro_objetivo.cod_macro = programa_setorial.cod_macro
    	    JOIN
                ppa.ppa
    	        ON ppa.cod_ppa = macro_objetivo.cod_ppa
    	    WHERE
                despesa.exercicio = :exercicio
    	    GROUP BY
                despesa.cod_recurso,
                despesa_acao.cod_acao,
                despesa.exercicio,
                ppa.ano_inicio
	    ) AS recursos
	    JOIN
            orcamento.recurso(:exercicio)
	        ON recurso.cod_recurso = recursos.cod_recurso
	    WHERE true
	        AND recursos.cod_acao = :codAcao AND recursos.ano = :codAno
	    GROUP BY
            recursos.cod_recurso,
            recurso.nom_recurso,
            recurso.masc_recurso,
            recursos.cod_acao
	    ORDER BY
            recursos.cod_recurso
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        
        $query->bindValue(":exercicio", $exercicio, \PDO::PARAM_STR);
        $query->bindValue(":codAno", $codAno, \PDO::PARAM_INT);
        $query->bindValue(":codAcao", $codAcao, \PDO::PARAM_INT);
        
        $query->execute();
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
