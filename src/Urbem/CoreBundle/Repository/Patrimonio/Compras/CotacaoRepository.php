<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class CotacaoRepository extends AbstractRepository
{
    public function getProximoCodCotacao($exercicio)
    {
        return $this->nextVal('cod_cotacao', ['exercicio' => $exercicio]);
    }
}
