<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ProgramaRepository extends AbstractRepository
{

    /**
     * @return int
     */
    public function getProximoCodGrupo()
    {
        return $this->nextVal("cod_programa");
    }

    /**
     * @return int
     */
    public function getProximoNumPrograma()
    {
        return $this->nextVal("num_programa");
    }
}
