<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class FaixaDescontoRepository extends AbstractRepository
{
    public function getNextFaixaDescontoCode()
    {
        return $this->nextVal('cod_faixa');
    }
}
