<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Fetch;

interface FetcherResultInterface
{
    /**
     * @return mixed
     */
    function getData();

    /**
     * @param string $code
     */
    function setCode($code);

    /**
     * @return string
     */
    function getCode();
}