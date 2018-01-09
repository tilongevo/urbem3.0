<?php

namespace Urbem\CoreBundle\Exception;

class AbstractException extends \Exception
{
    /**
     * @param string $message The exception message
     * @param int $code The exception code
     * @param \Exception $previous The previous exception
     */
    public function __construct($message = 'Generic Error', $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
