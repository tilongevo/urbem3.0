<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ParametroCalculoRepository
 * @package Urbem\CoreBundle\Repository\Arrecadacao
 */
class ParametroCalculoRepository extends AbstractRepository
{
    /**
     * @param $params
     * @return int
     */
    public function getNextVal($params)
    {
        return $this->nextVal(
            "ocorrencia_credito",
            [
                'cod_credito' => $params['cod_credito'],
                'cod_especie' => $params['cod_especie'],
                'cod_natureza' => $params['cod_natureza'],
                'cod_genero' => $params['cod_genero']
            ]
        );
    }
}
