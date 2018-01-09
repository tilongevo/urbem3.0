<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Result\Status;

use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldCollectionInterface;

interface StatusResponseInterface
{
    /**
     * @return string
     */
    function getMensagem();

    /**
     * @return string
     */
    function getStatus();

    /**
     * @return FieldCollectionInterface
     */
    function getFields();
}
