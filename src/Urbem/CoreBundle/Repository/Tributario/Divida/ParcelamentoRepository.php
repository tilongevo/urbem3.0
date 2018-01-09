<?php

namespace Urbem\CoreBundle\Repository\Tributario\Divida;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ParcelamentoRepository extends AbstractRepository
{
    /**
     * @param string
     * @param array
     * @return int
     */
    public function getNextVal($campo, $params = [])
    {
        return $this->nextVal($campo, $params);
    }
}
