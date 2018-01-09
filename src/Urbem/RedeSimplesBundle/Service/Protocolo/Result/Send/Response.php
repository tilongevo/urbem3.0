<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Result\Send;

class Response implements SendResponseInterface
{
    /**
     * @var string
     */
    protected $protocolo;

    public function __construct(array $response)
    {
        $this->protocolo = (string) $response['protocol'];
    }

    /**
     * @return string
     */
    public function getProtocolo()
    {
        return $this->protocolo;
    }
}
