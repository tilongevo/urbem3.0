<?php
namespace Urbem\CoreBundle\Helper;

/**
 * Provide static functions to perform number operations
 * Class NumberHelper
 * @package Urbem\CoreBundle\Helper
 */
class NumberHelper
{
    /**
     * Convert floating numbers with comma separator into dot separator
     * @param float $number
     * @return float
     */
    public static function floatToDatabase($number)
    {
        return (float) strtr($number, ',', '.');
    }

    /**
     * @param float $number
     * @param integer $precision
     * @param integer $scale
     * @return bool
     */
    public static function isValidNumber($number, $precision, $scale)
    {
        if (! is_numeric($number)) {
            $number =  self::floatToDatabase($number);
        }
        $isValid = false;
        if (is_numeric($number)) {
            $num = round(abs($number), $scale);
            $max = str_repeat('9', $precision - $scale).'.'.str_repeat('9', $scale);
            $isValid = $num <= $max;
        }
        return $isValid;
    }
}
