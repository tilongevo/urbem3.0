<?php

namespace Urbem\CoreBundle\Helper;

class DateTimeIdHelper extends \DateTime
{
    public function __toString()
    {
        return $this->format('U');
    }
}
