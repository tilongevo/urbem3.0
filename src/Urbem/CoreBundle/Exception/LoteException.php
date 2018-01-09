<?php

namespace Urbem\CoreBundle\Exception;

class LoteException extends AbstractException implements NotFoundException
{
    public function __construct(\Exception $previous = null)
    {
        parent::__construct($previous);
    }
}
