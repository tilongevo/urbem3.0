<?php

namespace Urbem\CoreBundle\Repository\Licitacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ConvenioAditivosRepository
 * @package Urbem\CoreBundle\Repository\Licitacao
 */
class ConvenioAditivosRepository extends AbstractRepository
{
    /**
     * @param string $campo
     * @param array  $params
     *
     * @return int
     */
    public function nextVal($campo, array $params = [])
    {
        return parent::nextVal($campo, $params);
    }
}
