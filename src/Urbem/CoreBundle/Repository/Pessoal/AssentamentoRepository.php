<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

class AssentamentoRepository extends AbstractRepository
{
    /**
     * Lista os assentamentos disponiveis por código de classificação de assentamento
     * e por código de registro (Matrícula)
     * @param  array  $params
     * @return array
     */
    public function getAssentamento(array $params)
    {
        $sql = <<<SQL
SELECT
    trim (paa.sigla) AS sigla_sem_espaco,
    to_char (av.dt_inicial, 'dd/mm/yyyy') AS data_inicial,
    to_char (av.dt_final, 'dd/mm/yyyy') AS data_final,
    to_char (ava.dt_inicial, 'dd/mm/yyyy') AS data_inicial_vantagem,
    to_char (ava.dt_final, 'dd/mm/yyyy') AS data_final_vantagem,
    av.cancelar_direito,
    paa.descricao,
    A.cod_assentamento
FROM
    pessoal.assentamento AS A
    INNER JOIN pessoal.assentamento_sub_divisao ON A.cod_assentamento = assentamento_sub_divisao.cod_assentamento
        AND A.timestamp = assentamento_sub_divisao.timestamp
        AND assentamento_sub_divisao.timestamp = (
            SELECT
                max (timestamp)
            FROM
                pessoal.assentamento_sub_divisao sdf
            WHERE
                assentamento_sub_divisao.cod_assentamento = sdf.cod_assentamento
                AND assentamento_sub_divisao.cod_sub_divisao = sdf.cod_sub_divisao)
        INNER JOIN pessoal.contrato_servidor_sub_divisao_funcao ON assentamento_sub_divisao.cod_sub_divisao = contrato_servidor_sub_divisao_funcao.cod_sub_divisao
            AND contrato_servidor_sub_divisao_funcao.timestamp = (
                SELECT
                    max (timestamp)
                FROM
                    pessoal.contrato_servidor_sub_divisao_funcao sdf
                WHERE
                    contrato_servidor_sub_divisao_funcao.cod_contrato = sdf.cod_contrato
                    AND contrato_servidor_sub_divisao_funcao.cod_sub_divisao = sdf.cod_sub_divisao)
            INNER JOIN pessoal.contrato ON contrato_servidor_sub_divisao_funcao.cod_contrato = contrato.cod_contrato
            LEFT JOIN pessoal.assentamento_assentamento AS paa ON A.cod_assentamento = paa.cod_assentamento
        LEFT JOIN pessoal.assentamento_vantagem AS ava ON A.cod_assentamento = ava.cod_assentamento
        AND A.timestamp = ava.timestamp
    LEFT JOIN (
        SELECT
            ad.*
        FROM
            pessoal.assentamento_afastamento_temporario AS AT,
            pessoal.assentamento_afastamento_temporario_duracao AS ad
        WHERE
            AT.cod_assentamento = ad.cod_assentamento
            AND AT.timestamp = ad.timestamp) AS tabela ON A.cod_assentamento = tabela.cod_assentamento
    AND A.timestamp = tabela.timestamp
    LEFT JOIN pessoal.assentamento_validade AS av ON A.cod_assentamento = av.cod_assentamento
    AND A.timestamp = av.timestamp, (
        SELECT
            cod_assentamento,
            max (timestamp) AS timestamp
        FROM
            pessoal.assentamento
        GROUP BY
            cod_assentamento) AS ult
WHERE
    A.cod_assentamento = ult.cod_assentamento
    AND A.timestamp = ult.timestamp
    AND cod_classificacao = :cod_classificacao
    AND registro = :registro
GROUP BY
    paa.sigla,
    av.dt_inicial,
    av.dt_final,
    ava.dt_inicial,
    ava.dt_final,
    av.cancelar_direito,
    paa.descricao,
    A.cod_assentamento
ORDER BY
    paa.descricao
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Retorna a lista de assentamento para ser usado no filtro
     * TODO: unificar com a função getAssentamento()
     * @param  array $params
     * @return array
     */
    public function getAssentamentoFiltro($params)
    {
        $sql = <<<SQL
SELECT
    trim (paa.sigla) AS sigla_sem_espaco,
    to_char (av.dt_inicial, 'dd/mm/yyyy') AS data_inicial,
    to_char (av.dt_final, 'dd/mm/yyyy') AS data_final,
    to_char (ava.dt_inicial, 'dd/mm/yyyy') AS data_inicial_vantagem,
    to_char (ava.dt_final, 'dd/mm/yyyy') AS data_final_vantagem,
    av.cancelar_direito,
    paa.descricao,
    A.cod_assentamento
FROM
    pessoal.assentamento AS A
    INNER JOIN pessoal.assentamento_sub_divisao ON A.cod_assentamento = assentamento_sub_divisao.cod_assentamento
        AND A.timestamp = assentamento_sub_divisao.timestamp
        AND assentamento_sub_divisao.timestamp = (
            SELECT
                max (timestamp)
            FROM
                pessoal.assentamento_sub_divisao sdf
            WHERE
                assentamento_sub_divisao.cod_assentamento = sdf.cod_assentamento
                AND assentamento_sub_divisao.cod_sub_divisao = sdf.cod_sub_divisao)
        INNER JOIN pessoal.contrato_servidor_sub_divisao_funcao ON assentamento_sub_divisao.cod_sub_divisao = contrato_servidor_sub_divisao_funcao.cod_sub_divisao
            AND contrato_servidor_sub_divisao_funcao.timestamp = (
                SELECT
                    max (timestamp)
                FROM
                    pessoal.contrato_servidor_sub_divisao_funcao sdf
                WHERE
                    contrato_servidor_sub_divisao_funcao.cod_contrato = sdf.cod_contrato
                    AND contrato_servidor_sub_divisao_funcao.cod_sub_divisao = sdf.cod_sub_divisao)
            INNER JOIN pessoal.contrato ON contrato_servidor_sub_divisao_funcao.cod_contrato = contrato.cod_contrato
            LEFT JOIN pessoal.assentamento_assentamento AS paa ON A.cod_assentamento = paa.cod_assentamento
        LEFT JOIN pessoal.assentamento_vantagem AS ava ON A.cod_assentamento = ava.cod_assentamento
        AND A.timestamp = ava.timestamp
    LEFT JOIN (
        SELECT
            ad.*
        FROM
            pessoal.assentamento_afastamento_temporario AS AT,
            pessoal.assentamento_afastamento_temporario_duracao AS ad
        WHERE
            AT.cod_assentamento = ad.cod_assentamento
            AND AT.timestamp = ad.timestamp) AS tabela ON A.cod_assentamento = tabela.cod_assentamento
    AND A.timestamp = tabela.timestamp
    LEFT JOIN pessoal.assentamento_validade AS av ON A.cod_assentamento = av.cod_assentamento
    AND A.timestamp = av.timestamp, (
        SELECT
            cod_assentamento,
            max (timestamp) AS timestamp
        FROM
            pessoal.assentamento
        GROUP BY
            cod_assentamento) AS ult
WHERE
    A.cod_assentamento = ult.cod_assentamento
    AND A.timestamp = ult.timestamp
    AND cod_classificacao = :cod_classificacao
GROUP BY
    paa.sigla,
    av.dt_inicial,
    av.dt_final,
    ava.dt_inicial,
    ava.dt_final,
    av.cancelar_direito,
    paa.descricao,
    A.cod_assentamento
ORDER BY
    paa.descricao
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Retorna o codigo de assentamento para ferias
     * @param integer $codContrato
     * @return mixed
     */
    public function getAssentamentoPrevidencia($codContrato)
    {
        $sql = <<<SQL
SELECT
    assentamento_assentamento.*
FROM
    pessoal.assentamento
    INNER JOIN pessoal.assentamento_assentamento ON assentamento.cod_assentamento = assentamento_assentamento.cod_assentamento
    INNER JOIN (
            SELECT
                cod_assentamento,
                max(TIMESTAMP) AS TIMESTAMP
            FROM
                pessoal.assentamento
            GROUP BY
                cod_assentamento) AS max_assentamento ON assentamento.cod_assentamento = max_assentamento.cod_assentamento
            AND assentamento.timestamp = max_assentamento.timestamp
        INNER JOIN pessoal.classificacao_assentamento ON assentamento_assentamento.cod_classificacao = classificacao_assentamento.cod_classificacao
        INNER JOIN folhapagamento.previdencia ON previdencia.cod_regime_previdencia = assentamento_assentamento.cod_regime_previdencia
        INNER JOIN pessoal.contrato_servidor_previdencia ON previdencia.cod_previdencia = contrato_servidor_previdencia.cod_previdencia
        INNER JOIN (
                SELECT
                    cod_contrato,
                    max(TIMESTAMP) AS TIMESTAMP
                FROM
                    pessoal.contrato_servidor_previdencia
                GROUP BY
                    cod_contrato) AS max_contrato_servidor_previdencia ON contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato
                AND contrato_servidor_previdencia.timestamp = max_contrato_servidor_previdencia.timestamp
            INNER JOIN (
                    SELECT
                        cod_contrato,
                        max(TIMESTAMP) AS TIMESTAMP
                    FROM
                        pessoal.contrato_servidor_sub_divisao_funcao
                    GROUP BY
                        cod_contrato) AS max_contrato_servidor_sub_divisao_funcao ON max_contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_sub_divisao_funcao.cod_contrato
                INNER JOIN pessoal.contrato_servidor_sub_divisao_funcao ON max_contrato_servidor_sub_divisao_funcao.cod_contrato = contrato_servidor_sub_divisao_funcao.cod_contrato
                    AND max_contrato_servidor_sub_divisao_funcao.timestamp = contrato_servidor_sub_divisao_funcao.timestamp
                INNER JOIN pessoal.assentamento_sub_divisao ON assentamento_sub_divisao.cod_assentamento = assentamento.cod_assentamento
                INNER JOIN (
                        SELECT
                            cod_assentamento,
                            max(TIMESTAMP) AS TIMESTAMP
                        FROM
                            pessoal.assentamento_sub_divisao
                        GROUP BY
                            cod_assentamento
                        ORDER BY
                            cod_assentamento) AS max_assentamento_sub_divisao ON assentamento_sub_divisao.cod_assentamento = max_assentamento_sub_divisao.cod_assentamento
                        AND assentamento_sub_divisao.timestamp = max_assentamento_sub_divisao.timestamp
                        AND assentamento_sub_divisao.cod_sub_divisao = contrato_servidor_sub_divisao_funcao.cod_sub_divisao
                        AND contrato_servidor_previdencia.bo_excluido = FALSE
                        AND assentamento.assentamento_automatico = TRUE
                        AND classificacao_assentamento.cod_tipo = 2
                        AND assentamento_assentamento.cod_motivo = 2
                        AND contrato_servidor_previdencia.cod_contrato = :cod_contrato
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('cod_contrato', $codContrato);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}
