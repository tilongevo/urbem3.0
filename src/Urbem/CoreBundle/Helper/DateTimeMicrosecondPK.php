<?php

namespace Urbem\CoreBundle\Helper;

use Exception;
use DateTimeZone;
use Doctrine\DBAL\Types\ConversionException;

class DateTimeMicrosecondPK extends AbstractDatePK
{
    const FORMAT = 'Y-m-d H:i:s.u';

    /**
     * @param $format
     * @param $time
     * @param \DateTimeZone|null $timezone
     * @return null
     * @throws ConversionException
     */
    public static function toPHPValue($format, $time, DateTimeZone $timezone = null)
    {
        if (is_null($time)) {
            return;
        }

        try {
            $timezone = $timezone ?: new DateTimeZone(date_default_timezone_get());

            $date = new self($time, $timezone);
            if (!$date) {
                throw new Exception();
            }
        } catch (Exception $e) {
            throw ConversionException::conversionFailedFormat($time, self::class, $format);
        }

        return $date;
    }
}
