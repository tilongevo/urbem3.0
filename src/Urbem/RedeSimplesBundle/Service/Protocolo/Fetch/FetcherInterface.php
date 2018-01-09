<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Fetch;

use Urbem\RedeSimplesBundle\Service\Protocolo\ParameterBagInterface;

interface FetcherInterface
{
    /**
     * @param ParameterBagInterface $parameters
     * @return FetcherResultInterface
     */
    public function fetch(ParameterBagInterface $parameters);
}
