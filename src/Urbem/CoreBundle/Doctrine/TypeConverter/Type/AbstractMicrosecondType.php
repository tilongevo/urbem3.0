<?php

namespace Urbem\CoreBundle\Doctrine\TypeConverter\Type;

abstract class AbstractMicrosecondType extends AbstractType
{
    /**
     * @param $table
     * @param $column
     * @return string
     */
    protected function createCommandUpdateColumnValue($table, $column)
    {
        static $timestamp = null;

        if (null === $timestamp) {
            $timestamp = str_pad(trim(rand(111111, 999999), 0), 6, STR_PAD_LEFT);
        }

        return sprintf('UPDATE %s SET "%s" = "%s" + INTERVAL \'%s microsecond\'', $table, $column, $column, $timestamp);
    }
}
