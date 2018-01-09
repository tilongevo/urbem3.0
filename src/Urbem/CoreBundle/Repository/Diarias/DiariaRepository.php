<?php

namespace Urbem\CoreBundle\Repository\Diarias;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class AdidoCedidoRepository
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class DiariaRepository extends AbstractRepository
{
    public function getProximoCodDiaria($codContrato)
    {
        return $this->nextVal(
            'cod_diaria',
            [
                'cod_contrato' => $codContrato
            ]
        );
    }
}
