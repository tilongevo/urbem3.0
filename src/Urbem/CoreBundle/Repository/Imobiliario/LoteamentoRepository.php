<?php

namespace Urbem\CoreBundle\Repository\Imobiliario;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class LoteamentoRepository
 * @package Urbem\CoreBundle\Repository\Imobiliario
 */
class LoteamentoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextVal()
    {
        return $this->nextVal("cod_loteamento");
    }
}
