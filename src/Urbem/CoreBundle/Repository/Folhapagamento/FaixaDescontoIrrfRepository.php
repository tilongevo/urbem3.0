<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class FaixaDescontoIrrfRepository
 * @package Urbem\CoreBundle\Repository\Folhapagamento
 */
class FaixaDescontoIrrfRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getProximoCodFaixa()
    {
        return $this->nextVal('cod_faixa');
    }
}
