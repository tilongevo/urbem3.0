<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ContratoAditivoItemRepository extends AbstractRepository
{
    public function getNextCodContratoAditivoItem()
    {
        return $this->nextVal('cod_contrato_aditivo_item');
    }
}
