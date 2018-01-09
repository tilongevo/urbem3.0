<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;

/**
 * Class Files
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class Files extends DataProcessAbstract implements DataProcessingInterface
{
    /**
     * @void
     */
    public function process()
    {
        $files = $this->dataCollection->findObjectByName(FieldsAndData::FILE_NAME);

        if ($files) {
            $files->setText(implode(", ", $files->getValue()));
        }
    }
}