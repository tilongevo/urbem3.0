<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;

class ContaDespesaRepository extends ORM\EntityRepository
{
    /**
     * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMConfigurarRGF1.php:70
     */
    const COD_ESTRUTURAL_EXERCICIO_ANTERIOR = '3.1.9.0.92';

    public function getMaxCodConta()
    {
        $sql = "SELECT MAX(cod_conta) FROM orcamento.conta_despesa";

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function getContaDespesaList()
    {
        $sql = "
            SELECT tabela.mascara_classificacao
                ,tabela.descricao
                ,tabela.exercicio
                ,conta_despesa.cod_conta
            FROM(
                SELECT mascara_classificacao,descricao, max(exercicio::INTEGER) as exercicio
                FROM (
                    SELECT conta_despesa.cod_estrutural as mascara_classificacao
                        ,trim(conta_despesa.descricao) as descricao
                        ,max(despesa.exercicio::INTEGER) as exercicio
                    FROM orcamento.despesa INNER JOIN orcamento.conta_despesa ON despesa.exercicio = conta_despesa.exercicio
                        AND despesa.cod_conta = conta_despesa.cod_conta
                    GROUP BY conta_despesa.cod_estrutural,conta_despesa.descricao

                    UNION

                    SELECT conta_despesa.cod_estrutural as mascara_classificacao
                        ,trim(conta_despesa.descricao) as descricao
                        ,max(conta_despesa.exercicio::INTEGER) as exercicio
                    FROM orcamento.conta_despesa JOIN empenho.restos_pre_empenho
                        ON REPLACE(conta_despesa.cod_estrutural,'.','') = restos_pre_empenho.cod_estrutural
                    LEFT JOIN orcamento.despesa  ON despesa.cod_conta = conta_despesa.cod_conta
                        AND despesa.exercicio = conta_despesa.exercicio
                    LEFT JOIN (
                        SELECT publico.fn_mascarareduzida(conta_despesa.cod_estrutural) AS cod_estrutural
                        FROM orcamento.despesa
                        INNER JOIN orcamento.conta_despesa ON despesa.exercicio = conta_despesa.exercicio
                            AND despesa.cod_conta = conta_despesa.cod_conta
                        GROUP BY conta_despesa.cod_estrutural
                    ) AS tabela_pai
                        ON conta_despesa.cod_estrutural like tabela_pai.cod_estrutural||'%'
                    WHERE tabela_pai.cod_estrutural IS NULL
                        AND despesa.cod_conta IS NULL
                    GROUP BY conta_despesa.cod_estrutural,conta_despesa.descricao
                ) AS max_exercicio
                GROUP BY mascara_classificacao, descricao
                ORDER BY mascara_classificacao
            ) as tabela
            JOIN orcamento.conta_despesa ON conta_despesa.cod_estrutural = tabela.mascara_classificacao
            AND conta_despesa.exercicio::INTEGER = tabela.exercicio
            ORDER BY tabela.mascara_classificacao";

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function getContaByMascaraAndExercicioAndModulo($mascara, $exercicio, $modulo)
    {
        $sql = sprintf(
            "SELECT
                orcamento.fn_consulta_class_despesa(
                    tabela.cod_conta,
                    max( tabela.exercicio ),
                    (
                        SELECT
                            configuracao.valor
                        FROM
                            administracao.configuracao
                        WHERE
                            configuracao.cod_modulo = %d
                            AND configuracao.parametro = 'masc_class_despesa'
                            AND configuracao.exercicio = tabela.exercicio
                    )
                ) AS mascara_classificacao,
                tabela.descricao,
                max( tabela.exercicio ) AS exercicio,
                tabela.cod_conta
            FROM
                (
                    SELECT
                        conta_despesa.cod_estrutural,
                        conta_despesa.descricao,
                        max( conta_despesa.exercicio ) AS exercicio,
                        conta_despesa.cod_conta
                    FROM
                        orcamento.conta_despesa LEFT JOIN orcamento.despesa ON
                        despesa.exercicio = conta_despesa.exercicio
                        AND despesa.cod_conta = conta_despesa.cod_conta LEFT JOIN empenho.restos_pre_empenho ON
                        replace(
                            conta_despesa.cod_estrutural,
                            '.',
                            ''
                        ) = restos_pre_empenho.cod_estrutural
                    WHERE
                        1 = 1
                        AND(
                            SELECT
                                count( 1 )
                            FROM
                                orcamento.conta_despesa d2
                            WHERE
                                d2.exercicio = conta_despesa.exercicio
                                AND d2.cod_estrutural LIKE publico.fn_mascarareduzida(conta_despesa.cod_estrutural) || '%%'
                        ) = 1
                        AND conta_despesa.exercicio = '%s'
                        AND(
                            (
                                conta_despesa.cod_estrutural <> '%s'
                                AND conta_despesa.cod_estrutural LIKE publico.fn_mascarareduzida('%s') || '%%'
                            )
                            OR replace(
                                conta_despesa.cod_estrutural,
                                '.',
                                ''
                            ) = replace(
                                '%s',
                                '.',
                                ''
                            )
                        )
                    GROUP BY
                        conta_despesa.cod_estrutural,
                        conta_despesa.descricao,
                        conta_despesa.exercicio,
                        conta_despesa.cod_conta,
                        despesa.cod_despesa
                ) AS tabela
            GROUP BY
                tabela.cod_conta,
                tabela.exercicio,
                tabela.descricao,
                tabela.exercicio,
                tabela.cod_estrutural
            ORDER BY
                tabela.cod_estrutural",
            $modulo,
            $exercicio,
            $mascara,
            $mascara,
            $mascara
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function getContasByMascarasAndExercicio($exercicio, $codEstrutural, $useLike = false)
    {
        $where = "pa.cod_conta = pc.cod_conta";
        $where .= " AND pa.exercicio = pc.exercicio";
        $where .= " AND pc.exercicio = '%s'";

        if ($useLike) {
            $where .= " AND pc.cod_estrutural like '%s%%'";
        }

        $sql = sprintf(
            "SELECT
                pa.cod_conta ,
                pc.exercicio ,
                pc.nom_conta ,
                pc.cod_classificacao ,
                pc.cod_estrutural
            FROM
                contabilidade.plano_analitica as pa,
                contabilidade.plano_conta as pc
            WHERE $where
            ORDER BY pc.cod_estrutural",
            $exercicio,
            $codEstrutural
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function getDotacaoOrcamentaria($exercicio, $param = null)
    {
        $where = '';
        if ($param) {
            $where = sprintf("AND (O.cod_despesa = %d OR CD.descricao LIKE '%%%s%%')", (int) $param, (string) $param);
        }

        $sql = "
        SELECT
            CD.cod_estrutural AS mascara_classificacao,
            CD.descricao,
            O.*,
            publico.fn_mascara_dinamica (
                (
                    SELECT
                        valor
                    FROM
                        administracao.configuracao
                    WHERE
                        parametro = 'masc_despesa'
                        AND exercicio = :exercicio ),
                O.num_orgao || '.' || O.num_unidade || '.' || O.cod_funcao || '.' || O.cod_subfuncao || '.' || PP.num_programa || '.' || PA.num_acao || '.' || REPLACE (
                    cd.cod_estrutural,
                    '.',
                    '' ) )
            || '.' || publico.fn_mascara_dinamica (
                (
                    SELECT
                        valor
                    FROM
                        administracao.configuracao
                    WHERE
                        parametro = 'masc_recurso'
                        AND exercicio = :exercicio ),
                CAST (
                    cod_recurso AS varchar ) ) AS dotacao
        FROM
            orcamento.conta_despesa AS CD,
            orcamento.despesa AS O
            JOIN orcamento.programa AS OP ON OP.cod_programa = O.cod_programa
            AND OP.exercicio = O.exercicio
            JOIN ppa.programa AS PP ON PP.cod_programa = OP.cod_programa
            JOIN orcamento.despesa_acao ON despesa_acao.cod_despesa = O.cod_despesa
            AND despesa_acao.exercicio_despesa = O.exercicio
            JOIN ppa.acao AS PA ON PA.cod_acao = despesa_acao.cod_acao
        WHERE
            CD.exercicio IS NOT NULL
            AND O.cod_conta = CD.cod_conta
            AND O.exercicio = CD.exercicio
            AND O.exercicio = :exercicio
            $where
        ORDER BY
            cod_despesa,
            publico.fn_mascarareduzida (
                CD.cod_estrutural )
        ";

        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue(":exercicio", $exercicio);

        $result->execute();

        return $result->fetchAll();
    }
    
    public function getContaDespesa($exercicio, $codConta)
    {
        $sql = "
        SELECT
            *
        FROM
            orcamento.conta_despesa cd
        WHERE
            cd.cod_conta = :cod_conta
            AND exercicio = :exercicio;
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":cod_conta", $codConta);
        $query->bindValue(":exercicio", $exercicio);
        
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }
    
    public function getDotacaoPorDespesa($exercicio, $codDespesa)
    {
        $sql = "
        SELECT
            CD.mascara_classificacao,
            ppa.acao.num_acao AS num_acao,
            trim (
                CD.descricao ) AS descricao,
            OD.*,
            R.cod_recurso,
            R.cod_fonte,
            publico.fn_mascara_dinamica (
                (
                    SELECT
                        valor
                    FROM
                        administracao.configuracao
                    WHERE
                        parametro = 'masc_despesa'
                        AND exercicio = :exercicio ),
                OD.num_orgao || '.' || OD.num_unidade || '.' || OD.cod_funcao || '.' || OD.cod_subfuncao || '.' || ppa.programa.num_programa || '.' || ppa.acao.num_acao || '.' || REPLACE (
                    cd.mascara_classificacao,
                    '.',
                    '' ) )
            || '.' || REPLACE (
                r.cod_fonte,
                '.',
                '' ) AS dotacao
        FROM
            orcamento.vw_classificacao_despesa AS CD,
            orcamento.despesa AS OD
            JOIN orcamento.programa_ppa_programa ON programa_ppa_programa.cod_programa = OD.cod_programa
            AND programa_ppa_programa.exercicio = OD.exercicio
            JOIN ppa.programa ON ppa.programa.cod_programa = programa_ppa_programa.cod_programa_ppa
            JOIN orcamento.pao_ppa_acao ON pao_ppa_acao.num_pao = OD.num_pao
            AND pao_ppa_acao.exercicio = OD.exercicio
            JOIN ppa.acao ON ppa.acao.cod_acao = pao_ppa_acao.cod_acao,
            orcamento.recurso AS R
        WHERE
            CD.exercicio IS NOT NULL
            AND OD.cod_conta = CD.cod_conta
            AND OD.exercicio = CD.exercicio
            AND OD.cod_recurso = R.cod_recurso
            AND OD.exercicio = R.exercicio
            AND CD.exercicio = :exercicio
            AND OD.cod_despesa = :cod_despesa
        ";
        
        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue(":exercicio", $exercicio);
        $result->bindValue(":cod_despesa", $codDespesa);

        $result->execute();
        return $result->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param string        $exercicio
     * @param string        $mascaraReduzida
     *      Exemplo: '3.3.9.0.30'
     * @param null|string   $notThisCodEstrutural
     *      Exemplo: '3.3.9.0.30.00.00.00.00'
     *
     * @return array
     */
    public function getListaCodEstruturalDespesa($exercicio, $mascaraReduzida, $notThisCodEstrutural = null)
    {
        $sql = <<<SQL
SELECT conta_despesa.cod_estrutural ,
       conta_despesa.cod_conta ,
       publico.fn_mascarareduzida(conta_despesa.cod_estrutural) AS mascara_reduzida ,
       conta_despesa.descricao
FROM orcamento.conta_despesa
WHERE conta_despesa.exercicio = :exercicio
  AND publico.fn_mascarareduzida(conta_despesa.cod_estrutural) LIKE publico.fn_mascarareduzida(:mascara_reduzida)||'%'
SQL;
        $params = [
            'exercicio' => $exercicio,
            'mascara_reduzida' => $mascaraReduzida
        ];

        if (!is_null($notThisCodEstrutural)) {
            $sql .= 'AND conta_despesa.cod_estrutural <> :cod_estrutural;';
            $params['cod_estrutural'] = $notThisCodEstrutural;
        }

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getClassificacaoDespesa($exercicio)
    {
        $sql = 'SELECT                                                                                  
                     *,                                                                                  
                     publico.fn_mascarareduzida(mascara_classificacao) as mascara_classificacao_reduzida   
                 FROM                                                                                    
                     orcamento.vw_classificacao_despesa                                                        
                 WHERE                                                                                   
                     exercicio IS NOT NULL                                                               
                 AND exercicio = :exercicio ORDER BY mascara_classificacao';

        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue(":exercicio", $exercicio);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMConfigurarRGF1.php:70
     *
     * @param $exercicio
     * @return ORM\QueryBuilder
     */
    public function getDespesaExercicioAnterior($exercicio)
    {
        $qb = $this->createQueryBuilder('ContaDespesa');
        $qb->where('ContaDespesa.exercicio = :exercicio');
        $qb->andWhere('ContaDespesa.codEstrutural LIKE :codEstrutural');
        $qb->setParameter('exercicio', $exercicio);
        $qb->setParameter('codEstrutural', self::COD_ESTRUTURAL_EXERCICIO_ANTERIOR .'%');

        return $qb;
    }
}
