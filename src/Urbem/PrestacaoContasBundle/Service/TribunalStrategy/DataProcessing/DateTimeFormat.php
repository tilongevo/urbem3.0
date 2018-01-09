<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
/**
 * Class DateTimeFormat
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class DateTimeFormat extends DataProcessAbstract implements DataProcessingInterface
{
    /**
     * @void
     */
    public function process()
    {
        $initialDate = $this->dataCollection->findObjectByName(FieldsAndData::INITIAL_DATE_NAME);
        $finalDate = $this->dataCollection->findObjectByName(FieldsAndData::FINAL_DATE_NAME);

        if ($initialDate && !empty($initialDate->getValue())) {
            $initialDate->setValue($initialDate->getValue()->format("d/m/Y"));
            $initialDate->setText($initialDate->getValue());
        }

        if ($finalDate && !empty($finalDate->getValue())) {
            $finalDate->setValue($finalDate->getValue()->format("d/m/Y"));
            $finalDate->setText($finalDate->getValue());
        }
    }
}
