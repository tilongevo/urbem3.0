<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class PrevidenciaPrevidenciaRepository extends AbstractRepository
{
    /** @var integer */
    const COD_VINCULO = 3;

    /**
     * Retorna o próximo código de previdência
     * @return integer
     */
    public function getNextPrevidenciaCode()
    {
        return $this->nextVal('cod_previdencia');
    }

    public function getPrevidenciaPrevidencia(array $params = array())
    {
        $params['cod_vinculo'] = self::COD_VINCULO;

        $sql = <<<SQL
SELECT
    previdencia.*,
    previdencia_previdencia.*,
    CASE
        WHEN contrato_servidor_previdencia.cod_contrato IS NULL THEN ''
        ELSE 'true'
    END AS booleano,
    CASE previdencia_previdencia.tipo_previdencia
        WHEN 'o' THEN 'Oficial'
        WHEN 'p' THEN 'Privada'
    END AS tipo_previdencia
FROM
    folhapagamento.previdencia_previdencia,
    (
        SELECT
            cod_previdencia,
            max (timestamp) AS timestamp
        FROM
            folhapagamento.previdencia_previdencia
        GROUP BY
            cod_previdencia)
    max_previdencia_previdencia,
    folhapagamento.previdencia
    LEFT JOIN (
        SELECT
            contrato_servidor_previdencia.cod_contrato,
            contrato_servidor_previdencia.cod_previdencia,
            contrato_servidor_previdencia.bo_excluido
        FROM
            pessoal.contrato_servidor_previdencia,
            (
                SELECT
                    cod_contrato,
                    max (timestamp) AS timestamp
                FROM
                    pessoal.contrato_servidor_previdencia
                GROUP BY
                    cod_contrato)
            max_contrato_servidor_previdencia
        WHERE
            contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato
            AND contrato_servidor_previdencia.timestamp = max_contrato_servidor_previdencia.timestamp
            AND contrato_servidor_previdencia.bo_excluido IS FALSE
            AND contrato_servidor_previdencia.cod_contrato = :cod_contrato) AS contrato_servidor_previdencia ON previdencia.cod_previdencia = contrato_servidor_previdencia.cod_previdencia
WHERE
    previdencia.cod_previdencia = previdencia_previdencia.cod_previdencia
    AND previdencia_previdencia.cod_previdencia = max_previdencia_previdencia.cod_previdencia
    AND previdencia_previdencia.timestamp = max_previdencia_previdencia.timestamp
    AND previdencia.cod_vinculo = :cod_vinculo
ORDER BY
    lower (previdencia_previdencia.descricao)
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
