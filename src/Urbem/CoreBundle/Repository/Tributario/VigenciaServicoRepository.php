<?php

namespace Urbem\CoreBundle\Repository\Tributario;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class VigenciaServicoRepository
 * @package Urbem\CoreBundle\Repository\Tributario
 */
class VigenciaServicoRepository extends AbstractRepository
{
    /**
     * @param $dtInicio
     * @return bool
     */
    public function isDataInicioMaior($dtInicio)
    {
        $isDataInicioMaior = false;
        $sql = " SELECT * FROM 
                (
                SELECT
                    MAX(dt_inicio) AS dataMaisRecente 
                FROM economico.vigencia_servico
                ) H
                WHERE H.dataMaisRecente < :dtInicio";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('dtInicio', $dtInicio);
        $query->execute();
        $result = $query->fetchAll();
        if ($result) {
            $isDataInicioMaior = true;
        }
        return $isDataInicioMaior;
    }

    /**
     * @return mixed
     */
    public function getVigenciaAtual()
    {
        $sql = "SELECT
                    cod_vigencia AS codVigencia,
                    TO_CHAR(NOW(), 'YYYY-MM-DD') AS dataAtual,
                    dt_inicio AS dataInicio
                FROM economico.vigencia_servico
                WHERE dt_inicio <= NOW()
                ORDER BY dt_inicio DESC
                LIMIT 1";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        $codVigencia = array_shift($result)['codvigencia'];

        return $codVigencia;
    }
}
