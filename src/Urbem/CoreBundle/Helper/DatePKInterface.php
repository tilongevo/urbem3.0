<?php

namespace Urbem\CoreBundle\Helper;

use Doctrine\DBAL\Types\ConversionException;

interface DatePKInterface extends \DateTimeInterface
{
    /**
     * @param $format
     * @param $time
     * @param \DateTimeZone|null $timezone
     * @return DatePKInterface
     * @throws ConversionException
     */
    public static function toPHPValue($format, $time, \DateTimeZone $timezone = null);
}
