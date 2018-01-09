<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class CompensacaoRepository extends AbstractRepository
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
