<?php

namespace Urbem\CoreBundle\Doctrine\TypeConverter\Type;

use Urbem\CoreBundle\Doctrine\DBAL\Type\DateTimeMicrosecondPKType;

class DateTimeMicrosecondType extends AbstractMicrosecondType
{
    /**
     * @param $table
     * @param $column
     * @return string
     */
    protected function createCommandUpdateColumnType($table, $column)
    {
        return sprintf('ALTER TABLE %s ALTER COLUMN "%s" TYPE TIMESTAMP(6) USING TO_TIMESTAMP(EXTRACT(epoch FROM "%s"))::TIMESTAMP(6);', $table, $column, $column);
    }

    /**
     * @return string
     */
    protected function getDoctrineTypeClassName()
    {
        return DateTimeMicrosecondPKType::class;
    }
}
