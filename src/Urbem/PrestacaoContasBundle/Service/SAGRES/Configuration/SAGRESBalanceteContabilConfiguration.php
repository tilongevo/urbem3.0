<?php

namespace Urbem\PrestacaoContasBundle\Service\SAGRES\Configuration;

use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

class SAGRESBalanceteContabilConfiguration extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParametersCollection();

        return $params->exportDataAndValueToArray();
    }
}