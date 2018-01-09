<?php

use Doctrine\ORM\QueryBuilder;

class DumpQuery
{
    public static function dump($qb, $echo = true, $exit = true)
    {
        $query = $qb instanceof QueryBuilder ? $qb->getQuery() : $qb;

        $sql = $query->getSQL();

        $queryReflection = new \ReflectionClass($query);
        $method = $queryReflection->getMethod('processParameterMappings');
        $method->setAccessible(true);

        $property = $queryReflection->getProperty('_parserResult');
        $property->setAccessible(true);
        $paramMappings = $property->getValue($query)->getParameterMappings();

        list($sqlParams, $types) = $method->invoke($query, $paramMappings);

        foreach ($sqlParams as $p) {
            $value = $p;

            if (true === is_object($p)) {
                if ($p instanceof \DateTime) {
                    $value = $p->format('Y-m-d H:i:s');

                } else {
                    $value = $p->getId();
                }
            }

            if (true === is_array($value)) {
                if (count($value) > 0) {
                    if (!is_int($value[0])) {
                        $value = "'" . implode("','", $value) . "'";
                    } else {
                        $value = implode(',', $value);
                    }

                } else {
                    $value = '';
                }

            } elseif (true === is_bool($value)) {
                $value = (int) $value;

            } elseif (false === is_int($value)) {

                $value = "'{$value}'";
            }

            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        $breakLinesSearch = [
            ' FROM ',
            ' INNER JOIN ',
            ' LEFT JOIN ',
            ' RIGHT JOIN ',
            ' WHERE ',
            ' GROUP BY ',
            ' ORDER BY ',
            ' HAVING ',
            ' LIMIT ',
        ];

        $breakLinesReplace = [];

        foreach ($breakLinesSearch as $breakLine) {
            $breakLinesReplace[] = PHP_EOL . ltrim($breakLine);
        }

        $sql = str_ireplace($breakLinesSearch, $breakLinesReplace, $sql);

        if (true === $echo) {
            echo sprintf('<pre>%s</pre>', $sql);

            if (true == $exit) {
                exit;
            }
        }

        return $sql;
    }
}

if (!function_exists('dumpquery')) {
    function dumpquery($qb)
    {
        DumpQuery::dump($qb);
    }
}
