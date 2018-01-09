<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\CoreBundle\Helper\MonthsHelper;

/**
 * Class Quarter
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class Quarter extends DataProcessAbstract implements DataProcessingInterface
{
    /**
     * @void
     */
    public function process()
    {
        $trimestre = $this->dataCollection->findObjectByName(FieldsAndData::PREFIX_NAME . FieldsAndData::QUARTER_NAME);

        if ($trimestre) {
            $trimestre->setText(sprintf("{$trimestre->getValue()}º %s", MonthsHelper::QUARTER_NAME));
        }
    }
}