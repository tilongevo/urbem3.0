<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class FaixaPagamentoSalarioFamiliaRepository
 * @package Urbem\CoreBundle\Repository\Folhapagamento
 */
class FaixaPagamentoSalarioFamiliaRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodFaixa()
    {
        return $this->nextVal('cod_faixa');
    }
}
