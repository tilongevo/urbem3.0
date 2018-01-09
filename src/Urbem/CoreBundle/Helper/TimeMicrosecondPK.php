<?php

namespace Urbem\CoreBundle\Helper;

class TimeMicrosecondPK extends AbstractDatePK
{
    const FORMAT = 'H:i:s.u';

    public function __construct($time = 'now', \DateTimeZone $timezone = null)
    {
        $date = new \DateTime($time, $timezone);

        if (0 === (int) $date->format('u')) {
            $ms = explode(',', microtime(true));
            $ms = 2 === count($ms) ? $ms : explode('.', end($ms));

            $time = sprintf('%s.%s', $date->format('H:i:s'), end($ms));
        }

        parent::__construct($time, $timezone);
    }
}
