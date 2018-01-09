<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Type;

use Urbem\PrestacaoContasBundle\Helper\ExportAdjustmentHelper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

class LeiAto extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParametersCollection();

        ExportAdjustmentHelper::setFinancialYear(
            $params,
            $this->factory
                ->getSession()
                ->getExercicio()
        );

        return $params->exportDataAndValueToArray();
    }
}