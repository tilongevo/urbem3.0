<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Patrimonio;

use Doctrine\ORM;

/**
 * Class ArquivoColetoraDadosRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio\Patrimonio
 */
class ArquivoColetoraDadosRepository extends ORM\EntityRepository
{


    /**
     * @param $numPlaca
     * @return array
     */
    public function consultaPlaca($numPlaca)
    {
        $sql = <<<SQL
SELECT
                     historico_bem.cod_local
                    ,historico_bem.cod_bem
                  FROM
                    patrimonio.historico_bem
            INNER JOIN
                (
                        SELECT
                             bem.cod_bem
                            ,max(timestamp) as timestamp
                          FROM
                            patrimonio.historico_bem
                    INNER JOIN
                            patrimonio.bem
                            ON
                            historico_bem.cod_bem = bem.cod_bem
                         WHERE
                            num_placa = '". $numPlaca ."'
                      GROUP BY
                            bem.cod_bem
                      ORDER BY
                            bem.cod_bem
                ) AS bem
                  ON
                    bem.cod_bem = historico_bem.cod_bem
                    AND bem.timestamp = historico_bem.timestamp
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
