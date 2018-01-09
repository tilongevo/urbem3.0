<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Parse;

use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;

interface ParserInterface
{
    /**
     * @param FetcherResultInterface $result
     * @return array
     */
    function parse(FetcherResultInterface $result);
}