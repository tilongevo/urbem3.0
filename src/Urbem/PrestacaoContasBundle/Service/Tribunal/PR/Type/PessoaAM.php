<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Type;

use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

class PessoaAM extends ConfiguracaoAbstract implements ConfiguracaoInterface
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