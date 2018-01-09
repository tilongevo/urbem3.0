<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class DescontoRepository extends AbstractRepository
{
    /**
     * @param $params
     * @return int
     */
    public function getNextVal($params)
    {
        return $this->nextVal(
            "cod_desconto",
            [
                'cod_grupo' => $params['cod_grupo'],
                'cod_vencimento' => $params['cod_vencimento'],
                'ano_exercicio' => $params['ano_exercicio']
            ]
        );
    }
}
