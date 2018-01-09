<?php

namespace Urbem\CoreBundle\Repository\Monetario;

use Urbem\CoreBundle\Repository\AbstractRepository;

class AcrescimoRepository extends AbstractRepository
{
    /**
     * @return mixed
     */
    public function getNextVal()
    {
        return $this->nextVal("cod_acrescimo");
    }
}
