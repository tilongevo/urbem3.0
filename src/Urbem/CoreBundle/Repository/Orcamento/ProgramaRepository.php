<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ProgramaRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getProximoCodPrograma()
    {
        return $this->nextVal("cod_programa");
    }
}
