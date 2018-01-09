<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Diarias;

use Urbem\CoreBundle\Repository\AbstractRepository;

class TipoDiariaRepository extends AbstractRepository
{
    public function getProximoCod()
    {
        return $this->nextVal('cod_tipo');
    }
}
