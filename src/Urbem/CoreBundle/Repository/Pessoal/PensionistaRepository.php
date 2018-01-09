<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class Pensionista
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class PensionistaRepository extends AbstractRepository
{
    /**
     * Retorna o próximo código do pensionista por codigo do contrato do cedente
     * @param  integer $codContratoCedente
     * @return integer
     */
    public function getNextCodPensionista($codContratoCedente)
    {
        return $this->nextVal(
            'cod_pensionista',
            [
                'cod_contrato_cedente' => $codContratoCedente
            ]
        );
    }
}
