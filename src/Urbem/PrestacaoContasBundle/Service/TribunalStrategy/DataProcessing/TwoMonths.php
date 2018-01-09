<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\CoreBundle\Helper\MonthsHelper;

/**
 * Class DataProcessingInterface
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class TwoMonths extends DataProcessAbstract implements DataProcessingInterface
{
    public function process()
    {
        $bimestre = $this->dataCollection->findObjectByName(FieldsAndData::PREFIX_NAME . FieldsAndData::TWO_MONTHS_NAME);

        if ($bimestre) {
            $bimestre->setText(sprintf("{$bimestre->getValue()}º %s", MonthsHelper::TWO_MONTH_NAME));
        }
    }
}