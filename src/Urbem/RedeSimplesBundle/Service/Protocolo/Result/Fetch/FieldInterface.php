<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch;

interface FieldInterface
{
    /**
     * @return string
     */
    function getName();

    /**
     * @return string
     */
    function getType();

    /**
     * @return array
     */
    function getOptions();
}
