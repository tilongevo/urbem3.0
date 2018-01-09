<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class PadraoRepository
 * @package Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento
 */
class PadraoRepository extends AbstractRepository
{
    /**
     * function montaRecuperaRelacionamentoPorContratosInativos() no sistema legado
     * @return array
     */
    public function getPadraoFilter()
    {
        $sql = <<<SQL
SELECT
    FP.cod_padrao,
    FP.descricao,
    to_char(FPP.vigencia,
        'dd/mm/yyyy') AS vigencia,
    FPP.cod_norma,
    FP.horas_mensais,
    FP.horas_semanais,
    FPP.valor,
    MAXTFPP.timestamp
FROM
    folhapagamento.padrao FP,
    folhapagamento.padrao_padrao FPP, (
        SELECT
            MAXFPP.cod_padrao,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            folhapagamento.padrao_padrao MAXFPP
        GROUP BY
            MAXFPP.cod_padrao) AS MAXTFPP
    WHERE
        FP.cod_padrao = MAXTFPP.cod_padrao
        AND FPP.cod_padrao = MAXTFPP.cod_padrao
        AND FPP.timestamp = MAXTFPP.timestamp
    ORDER BY
        upper(descricao)
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getPadraoSalarial($params)
    {
        $sql = <<<SQL
SELECT
    FP.cod_padrao,
    FP.descricao,
    to_char(FPP.vigencia,
        'dd/mm/yyyy') AS vigencia,
    FPP.cod_norma,
    FP.horas_mensais,
    FP.horas_semanais,
    FPP.valor,
    MAXTFPP.timestamp
FROM
    folhapagamento.padrao FP,
    folhapagamento.padrao_padrao FPP, (
        SELECT
            MAXFPP.cod_padrao,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            folhapagamento.padrao_padrao MAXFPP
        GROUP BY
            MAXFPP.cod_padrao) AS MAXTFPP
    WHERE
        FP.cod_padrao = MAXTFPP.cod_padrao
        AND FPP.cod_padrao = MAXTFPP.cod_padrao
        AND FPP.timestamp = MAXTFPP.timestamp
        AND FPP.cod_padrao = :codPadrao
        AND FPP.vigencia <= to_date(:vigencia, 'dd/mm/yyyy')
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}
