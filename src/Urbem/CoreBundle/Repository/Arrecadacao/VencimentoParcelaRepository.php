<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class VencimentoParcelaRepository extends AbstractRepository
{
    /**
     * @param $params
     * @return int
     */
    public function getNextVal($params)
    {
        return $this->nextVal(
            "cod_parcela",
            [
                'cod_grupo' => $params['cod_grupo'],
                'cod_vencimento' => $params['cod_vencimento'],
                'ano_exercicio' => $params['ano_exercicio']
            ]
        );
    }
}
