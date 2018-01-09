<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Fetch;

use Symfony\Component\HttpFoundation\Response;

class FetcherResult implements FetcherResultInterface
{
    const OK = Response::HTTP_OK;
    const UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    const BAD_REQUEST = Response::HTTP_BAD_REQUEST;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $code;

    /**
     * FetcherResult constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        if (false === in_array($code, [self::OK, self::BAD_REQUEST, self::UNAUTHORIZED])) {
            $code = self::BAD_REQUEST;
        }

        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}