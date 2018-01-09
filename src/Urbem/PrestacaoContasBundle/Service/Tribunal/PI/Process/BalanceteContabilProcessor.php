<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PI\Process;

use Urbem\PrestacaoContasBundle\Service\SAGRES\Process\SAGRESBalanceteContabilProcessor;

class BalanceteContabilProcessor extends SAGRESBalanceteContabilProcessor
{
    protected $uf = "PI";
}