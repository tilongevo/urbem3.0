<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class DestinacaoRecursoRepository extends AbstractRepository
{
    public function getNewDestinacaoRecurso($exercicio)
    {
        return $this->nextVal('cod_destinacao', ['exercicio' => $exercicio]);
    }
}
