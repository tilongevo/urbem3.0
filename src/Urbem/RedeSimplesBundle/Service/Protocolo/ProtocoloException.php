<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo;

use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResult;

class ProtocoloException extends \Exception
{
    public static function expectedMethodReturnType($from, $method, $expected, $given)
    {
        return new self(sprintf(
            '%s->%s() must return an instance of %s but %s was given.',
            $from,
            $method,
            $expected,
            (true === is_object($given) ? get_class($given) : gettype($given))
        ));
    }

    public static function expectedArrayKeyType($from, $key, $expected, $given)
    {
        return new self(sprintf(
            '%s[%s] expected to be instance of %s but %s was given.',
            $from,
            $key,
            $expected,
            (true === is_object($given) ? get_class($given) : gettype($given))
        ));
    }

    public static function expectedType($from, $expected, $given)
    {
        return new self(sprintf(
            '%s expected to be %s but %s was given.',
            $from,
            $expected,
            (true === is_object($given) ? get_class($given) : gettype($given))
        ));
    }

    public static function invalidResponse(FetcherResult $result)
    {
        return new self(sprintf('fetch return code %s', $result->getCode()));
    }
}