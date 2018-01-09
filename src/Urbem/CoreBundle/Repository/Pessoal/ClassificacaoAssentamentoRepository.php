<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ClassificacaoAssentamentoRepository extends AbstractRepository
{
    /**
     * Lista os assentamentos disponiveis por código de classificação de assentamento
     * e por código de contrato (Matrícula)
     * @param  array  $params
     * @return array
     */
    public function getClassificacaoAssentamento(array $params)
    {
        $sql = "
        SELECT
            ca.*,
            trim (tc.descricao) AS descricao_tipo
        FROM
            pessoal.classificacao_assentamento AS ca
            INNER JOIN pessoal.tipo_classificacao AS tc ON ca.cod_tipo = tc.cod_tipo
            INNER JOIN pessoal.assentamento_assentamento ON ca.cod_classificacao = assentamento_assentamento.cod_classificacao
            INNER JOIN pessoal.assentamento ON assentamento_assentamento.cod_assentamento = assentamento.cod_assentamento
                AND assentamento.timestamp = (
                    SELECT
                        max (timestamp)
                    FROM
                        pessoal.assentamento sdf
                    WHERE
                        assentamento.cod_assentamento = sdf.cod_assentamento)
                INNER JOIN pessoal.assentamento_sub_divisao ON assentamento_sub_divisao.cod_assentamento = assentamento.cod_assentamento
                    AND assentamento_sub_divisao.timestamp = assentamento.timestamp
                    AND assentamento_sub_divisao.timestamp = (
                        SELECT
                            max (timestamp)
                        FROM
                            pessoal.assentamento_sub_divisao sdf
                        WHERE
                            assentamento_sub_divisao.cod_assentamento = sdf.cod_assentamento
                            AND assentamento_sub_divisao.cod_sub_divisao = sdf.cod_sub_divisao)
                    INNER JOIN pessoal.contrato_servidor_sub_divisao_funcao ON contrato_servidor_sub_divisao_funcao.cod_sub_divisao = assentamento_sub_divisao.cod_sub_divisao
                        AND contrato_servidor_sub_divisao_funcao.timestamp = (
                            SELECT
                                max (timestamp)
                            FROM
                                pessoal.contrato_servidor_sub_divisao_funcao sdf
                            WHERE
                                contrato_servidor_sub_divisao_funcao.cod_contrato = sdf.cod_contrato
                                AND contrato_servidor_sub_divisao_funcao.cod_sub_divisao = sdf.cod_sub_divisao)
                        INNER JOIN pessoal.contrato ON contrato.cod_contrato = contrato_servidor_sub_divisao_funcao.cod_contrato
                        WHERE
                            contrato.registro = :registro
                        GROUP BY
                            ca.cod_classificacao,
                            ca.cod_tipo,
                            ca.descricao,
                            tc.descricao
                        ORDER BY
                            ca.descricao
        ";
        
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
