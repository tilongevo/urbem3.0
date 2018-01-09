<?php
namespace Urbem\CoreBundle\Helper;

class ArrayHelper
{
    public static function parseArrayToChoice($array, $campoChave, $campoValor)
    {
        if (empty($array)) {
            return $array;
        }

        $result = [];
        foreach($array as $key) {
            $result[$key[$campoChave]] = $key[$campoValor];
        }

        return $result;
    }

    public static function parseInvertArrayToChoice($array, $camelcase = false, $keyToInt = false)
    {
        if (empty($array)) {
            return $array;
        }

        $result = [];
        foreach($array as $key => $value) {
            $value = $camelcase ? ucwords(mb_strtolower($value, 'UTF-8')) : $value;
            $result[$value] = true === $keyToInt ? (int) $key : $key;
        }

        return $result;
    }

    public static function parseCollectionToString($collection, $field, $delimiter)
    {
        $result = [];
        foreach ($collection as $value) {
            $result[] = (string)$value->$field();
        }

        if (count($result)) {
            return implode($delimiter, $result);
        }

        return [];
    }

    public static function parseCollectionToArray($collection)
    {
        $result = [];
        foreach ($collection as $content) {
            $result[] = get_object_vars($content);
        }

        return $result;
    }

    /**
     * @param array $array
     * @param $field
     * @param $valueSearch
     * @param bool $removeAfter
     * @param null $fieldOrderBy
     * @return array
     */
    public static function searchCollectionById(array &$array, $field, $valueSearch, $removeAfter = false, $fieldOrderBy = null)
    {
        $newArray = [];
        foreach ($array as $key => $object) {
            $getField = sprintf("get%s", ucfirst($field));

            if ($object->$getField() === $valueSearch) {
                $newArray[] = $object;

                if ($removeAfter) {
                    unset($array[$key]);
                }
            }
        }

        return $newArray;
    }

    /**
     * @param array $required
     * @param array $arr
     * @return bool
     */
    public static function arrayMultiKeysExists(array $required, array $arr)
    {
        return count(array_intersect_key(array_flip($required), $arr)) == count($required);
    }

    /**
     * @param array $arr
     * @return array
     */
    public static function transoformAllNullDataInZeros(array $arr)
    {
        return array_map(function ($value) {
            return (true == is_null($value)) ? 0 : $value;
        }, $arr);
    }

    public static function searchBy($keySearch, $textSearch, $arrayFrom)
    {
        foreach ($arrayFrom as $key => $val) {
            if (!array_key_exists($keySearch, $val)) {
                return null;
            }

            if ($val[$keySearch] === $textSearch) {
                return $arrayFrom[$key];
            }
        }
        return null;
    }
}
