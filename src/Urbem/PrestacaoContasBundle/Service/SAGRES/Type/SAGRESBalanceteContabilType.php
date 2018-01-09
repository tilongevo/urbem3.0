<?php

namespace Urbem\PrestacaoContasBundle\Service\SAGRES\Type;

use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Helper\ExportAdjustmentHelper;

class SAGRESBalanceteContabilType extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParametersCollection();

        ExportAdjustmentHelper::setFinancialYear(
            $params,
            $this->factory->getSession()->getExercicio()
        );

        $this->processInformationByData($params, parent::PROCESS_ENTIDADE);
        $this->processInformationByData($params, parent::PROCESS_FILES);
        $this->processInformationByData($params, parent::PROCESS_MONTH);

        return $params->exportDataAndValueToArray();
    }
}