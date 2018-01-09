<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\CoreBundle\Helper\MonthsHelper;

/**
 * Class Month
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class Month extends DataProcessAbstract implements DataProcessingInterface
{
    /**
     * @void
     */
    public function process()
    {
        $month = $this->dataCollection->findObjectByName(FieldsAndData::MONTH_NAME);
        if ($month) {
            $value = MonthsHelper::getMonthName($month->getValue());
            if (!is_numeric($value)) {
                $value = ucfirst(strtolower($value));
            }
            $month->setText($value);
        }
    }
}