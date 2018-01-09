<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\CoreBundle\Helper\MonthsHelper;

/**
 * Class FourMonthPeriod
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class FourMonthPeriod extends DataProcessAbstract implements DataProcessingInterface
{
    /**
     * @void
     */
    public function process()
    {
        $quadrimestre = $this->dataCollection->findObjectByName(FieldsAndData::PREFIX_NAME . FieldsAndData::FOUR_MONTH_PERIOD_NAME);

        if ($quadrimestre) {
            $quadrimestre->setText(sprintf("{$quadrimestre->getValue()}º %s", MonthsHelper::FOUR_MONTH_PERIOD_NAME));
        }
    }
}
