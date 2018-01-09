<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Fetch;

abstract class FetcherAbstract implements FetcherInterface
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param FetcherParametersInterface $parameters
     * @return mixed
     */
    abstract protected function doFetch(FetcherParametersInterface $parameters);

    /**
     * @param FetcherParametersInterface $parameters
     * @return FetcherResult
     */
    public function fetch(FetcherParametersInterface $parameters)
    {
        return new FetcherResult($this->doFetch($parameters));
    }
}