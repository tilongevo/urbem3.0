<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class FgtsRepository extends AbstractRepository
{
    public function getNextCodFgts()
    {
        return $this->nextVal('cod_fgts');
    }
}
