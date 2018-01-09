<?php

namespace Urbem\CoreBundle\Doctrine\TypeConverter\Type;

use Urbem\CoreBundle\Doctrine\DBAL\Type\TimeMicrosecondPKType;

class TimeMicrosecondType extends AbstractMicrosecondType
{
    /**
     * @param $table
     * @param $column
     * @return string
     */
    protected function createCommandUpdateColumnType($table, $column)
    {
        return sprintf('ALTER TABLE %s ALTER COLUMN "%s" TYPE TIME(6) USING TO_TIMESTAMP(EXTRACT(epoch FROM "%s"))::TIME(6);', $table, $column, $column);
    }

    /**
     * @return string
     */
    protected function getDoctrineTypeClassName()
    {
        return TimeMicrosecondPKType::class;
    }
}
