<?php

namespace Urbem\CoreBundle\Services\Orcamento\Suplementacao\Type;

use Urbem\CoreBundle\Services\Orcamento\Suplementacao\Lancamento;

abstract class LancamentoType
{
    abstract public function execute(Lancamento $lancamento);
}
