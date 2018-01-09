<?php

namespace Urbem\CoreBundle\Repository\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class GrupoRepository extends AbstractRepository
{
    public function getProximoCodGrupo($codNatureza)
    {
        return $this->nextVal('cod_grupo', ['cod_natureza' => $codNatureza]);
    }
}
