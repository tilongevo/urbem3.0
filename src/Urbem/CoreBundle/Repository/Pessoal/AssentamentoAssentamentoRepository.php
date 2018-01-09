<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

class AssentamentoAssentamentoRepository extends AbstractRepository
{
    /**
     * @param $codClassificacao
     * @return array
     */
    public function getAssentamentosByCodClassificacao($codClassificacao)
    {
        $sql = <<<SQL
SELECT
    trim(paa.sigla) AS sigla_sem_espaco,
    trim(paa.abreviacao) AS abreviacao,
    paa.descricao AS descricao,
    A.*
FROM
    pessoal.assentamento AS A
    LEFT JOIN pessoal.assentamento_assentamento AS paa ON A.cod_assentamento = paa.cod_assentamento, (
        SELECT
            cod_assentamento,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            pessoal.assentamento
        GROUP BY
            cod_assentamento) AS ult
    WHERE
        A.cod_assentamento = ult.cod_assentamento
        AND A.timestamp = ult.timestamp
        AND A.cod_assentamento NOT IN (
            SELECT
                ca.cod_assentamento
            FROM
                pessoal.condicao_assentamento AS ca, (
                    SELECT
                        cod_assentamento,
                        max(TIMESTAMP) AS TIMESTAMP
                    FROM
                        pessoal.condicao_assentamento
                    GROUP BY
                        cod_assentamento) AS ult
                WHERE
                    ca.cod_assentamento = ult.cod_assentamento
                    AND ca.timestamp = ult.timestamp
                    AND ca.cod_condicao::varchar || ca.cod_assentamento::varchar || ca.timestamp::varchar NOT IN (
                        SELECT
                            cod_condicao::varchar || cod_assentamento::varchar || TIMESTAMP::varchar
                        FROM
                            pessoal.condicao_assentamento_excluido))
                    AND cod_classificacao = :codClassificacao
                ORDER BY
                    paa.descricao;
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindParam('codClassificacao', $codClassificacao);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getAssentamentoByCodSubDivisao($params)
    {
        $sql = <<<SQL
SELECT
    assentamento_assentamento.*,
    assentamento.assentamento_automatico
FROM
    pessoal.assentamento, (
        SELECT
            cod_assentamento,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            pessoal.assentamento
        GROUP BY
            cod_assentamento) AS max_assentamento,
        pessoal.assentamento_assentamento,
        pessoal.classificacao_assentamento,
        pessoal.assentamento_sub_divisao, (
            SELECT
                cod_assentamento,
                max(TIMESTAMP) AS TIMESTAMP
            FROM
                pessoal.assentamento_sub_divisao
            GROUP BY
                cod_assentamento) AS max_assentamento_sub_divisao
        WHERE
            assentamento.cod_assentamento = assentamento_assentamento.cod_assentamento
            AND assentamento.cod_assentamento = max_assentamento.cod_assentamento
            AND assentamento.timestamp = max_assentamento.timestamp
            AND assentamento_assentamento.cod_classificacao = classificacao_assentamento.cod_classificacao
            AND assentamento.cod_assentamento = assentamento_sub_divisao.cod_assentamento
            AND assentamento_sub_divisao.cod_assentamento = max_assentamento_sub_divisao.cod_assentamento
            AND assentamento_sub_divisao.timestamp = max_assentamento_sub_divisao.timestamp
            AND (assentamento_assentamento.cod_motivo = 11
                OR assentamento_assentamento.cod_motivo = 12
                OR assentamento_assentamento.cod_motivo = 13)
            AND assentamento_sub_divisao.cod_sub_divisao = :cod_sub_divisao
SQL;
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute($params);
        $result = $query->fetch(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codContrato
     * @param string $dtInicial
     * @param string $dtFinal
     * @return array
     */
    public function recuperaRelacionamento($codContrato, $dtInicial = null, $dtFinal = null)
    {
        $sql = "
            select
                assentamento_assentamento.*
            from
                pessoal.assentamento,
                (
                    select
                        cod_assentamento,
                        max( timestamp ) as timestamp
                    from
                        pessoal.assentamento
                    group by
                        cod_assentamento
                ) as max_assentamento,
                pessoal.assentamento_assentamento,
                pessoal.classificacao_assentamento,
                folhapagamento.previdencia,
                pessoal.contrato_servidor_previdencia,
                (
                    select
                        cod_contrato,
                        max( timestamp ) as timestamp
                    from
                        pessoal.contrato_servidor_previdencia
                    group by
                        cod_contrato
                ) as max_contrato_servidor_previdencia
            where
                assentamento.cod_assentamento = assentamento_assentamento.cod_assentamento
                and assentamento.cod_assentamento = max_assentamento.cod_assentamento
                and assentamento.timestamp = max_assentamento.timestamp
                and assentamento_assentamento.cod_classificacao = classificacao_assentamento.cod_classificacao
                and previdencia.cod_previdencia = contrato_servidor_previdencia.cod_previdencia
                and contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato
                and contrato_servidor_previdencia.timestamp = max_contrato_servidor_previdencia.timestamp";

        if ($dtInicial && $dtFinal) {
            $sql .= "
              AND EXISTS (  SELECT 1                                                                                                                                                     
                          FROM pessoal.assentamento_gerado_contrato_servidor                                                                                                         
                    INNER JOIN pessoal.assentamento_gerado                                                                                                                           
                            ON assentamento_gerado_contrato_servidor.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                                           
                    INNER JOIN pessoal.assentamento_assentamento as assentamento_assentamento_interno                                                                                
                            ON assentamento_gerado.cod_assentamento = assentamento_assentamento.cod_assentamento                                                                     
                    INNER JOIN ( SELECT cod_assentamento_gerado                                                                                                                      
                                      , max(timestamp) as timestamp                                                                                                                  
                                   FROM pessoal.assentamento_gerado                                                                                                                  
                               GROUP BY cod_assentamento_gerado) as max_assentamento_gerado                                                                                          
                            ON assentamento_gerado.cod_assentamento_gerado = max_assentamento_gerado.cod_assentamento_gerado                                                         
                           AND assentamento_gerado.timestamp = max_assentamento_gerado.timestamp                                                                                     
                         WHERE assentamento_gerado_contrato_servidor.cod_contrato = contrato_servidor_previdencia.cod_contrato                                                       
                           AND to_date('$dtInicial', 'dd/mm/yyyy') BETWEEN assentamento_gerado.periodo_inicial AND assentamento_gerado.periodo_final            
                            OR to_date('$dtFinal', 'dd/mm/yyyy') BETWEEN assentamento_gerado.periodo_inicial AND assentamento_gerado.periodo_final              
                            OR ( assentamento_gerado.periodo_inicial >= to_date('$dtInicial', 'dd/mm/yyyy') AND assentamento_gerado.periodo_final <= to_date('$dtFinal', 'dd/mm/yyyy'))  
                           AND NOT EXISTS (SELECT 1                                                                                                                                  
                                             FROM pessoal.assentamento_gerado_excluido                                                                                               
                                            WHERE assentamento_gerado_excluido.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado                                 
                                              AND assentamento_gerado_excluido.timestamp = assentamento_gerado.timestamp))";
        }

        $sql .= "
            AND contrato_servidor_previdencia.bo_excluido = false
            AND assentamento.assentamento_automatico = true
            AND classificacao_assentamento.cod_tipo = 2
            AND assentamento_assentamento.cod_motivo = 2
            AND contrato_servidor_previdencia.cod_contrato = $codContrato; ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
