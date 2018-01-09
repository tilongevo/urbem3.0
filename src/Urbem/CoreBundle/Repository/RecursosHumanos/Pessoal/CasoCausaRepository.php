<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class CasoCausaRepository
 * @package Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal
 */
class CasoCausaRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodCasoCausa()
    {
        return $this->nextVal('cod_caso_causa');
    }

    /**
     * Retorna a descricao do caso da causa
     * @param  array  $params
     * @return object
     */
    public function getDescricaoCasoCausa($params)
    {
        $sql = "
        SELECT
            pcc.cod_caso_causa,
            pcc.descricao,
            pcc.paga_aviso_previo
        FROM
            pessoal.caso_causa AS pcc,
            pessoal.causa_rescisao AS pcr,
            pessoal.caso_causa_sub_divisao AS pccsd
        WHERE
            pcc.cod_causa_rescisao = pcr.cod_causa_rescisao
            AND pcr.cod_causa_rescisao = :codCausaRescisao
            AND pcc.cod_caso_causa IN (
                SELECT
                    pcca.cod_caso_causa
                FROM
                    pessoal.periodo_caso ppc,
                    pessoal.caso_causa pcca,
                    pessoal.grupo_periodo pgp
                WHERE
                    ppc.cod_periodo = pcca.cod_periodo
                    AND pgp.cod_grupo_periodo = ppc.cod_grupo_periodo
                    AND :meses BETWEEN periodo_inicial
                    AND periodo_final)
            AND pccsd.cod_caso_causa = pcc.cod_caso_causa
            AND pccsd.cod_sub_divisao = :codSubDivisao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute($params);
        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result;
    }
}
