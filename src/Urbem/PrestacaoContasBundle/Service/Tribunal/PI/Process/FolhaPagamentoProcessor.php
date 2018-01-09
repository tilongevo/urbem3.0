<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PI\Process;

use Urbem\PrestacaoContasBundle\Service\SAGRES\Process\SAGRESFolhaPagamentoProcessor;

class FolhaPagamentoProcessor extends SAGRESFolhaPagamentoProcessor
{
    protected $uf = "PI";
}