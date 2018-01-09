<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\CoreBundle\Exception\Error;
use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;

/**
 * Class ReportType
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class ReportType extends DataProcessAbstract implements DataProcessingInterface
{
    /**
     * @void
     */
    public function process()
    {
        $reportType = $this->dataCollection->findObjectByName(FieldsAndData::REPORT_TYPE_NAME);

        switch ($reportType->getValue()) {
            case FieldsAndData::TWO_MONTHS_NAME:
                $class = ConfiguracaoAbstract::PROCESS_TWO_MONTHS;
                break;
            case FieldsAndData::QUARTER_NAME:
                $class = ConfiguracaoAbstract::PROCESS_QUARTER;
                break;
            case FieldsAndData::FOUR_MONTH_PERIOD_NAME:
                $class = ConfiguracaoAbstract::PROCESS_FOUR_MONTH_PERIOD;
                break;
            default:
                throw new \Exception(Error::CLASS_NOT_FOUND);
        }

        $class = sprintf(ConfiguracaoAbstract::NAMESPACE_PROCESS_CLASS, $class);
        $class = new $class($this->factory, $this->dataCollection);
        $class->process();
    }
}