<?php

namespace Urbem\CoreBundle\Helper;

use Doctrine\Common\Collections\Collection;

use Urbem\AdministrativoBundle\Helper\Constants\TipoAtributo;

/**
 * Class StringHelper
 *
 * @package Urbem\CoreBundle\Helper
 */
class StringHelper
{
    const PATTERN_REPLACE = "/[-().\/]+/im";

    public static function clearString($string, $pattern = self::PATTERN_REPLACE)
    {
        if (empty(self::removeAllSpace($string))) {
            return $string;
        }

        return preg_replace($pattern, '', $string);
    }

    public static function removeAllSpace($string)
    {
        return preg_replace('/\s+/', '', $string);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function removeExcessSpace($string)
    {
        return preg_replace('/\s+/', ' ', $string);
    }

    public static function ucname($string, $newDelimiter = null)
    {
        $string =ucwords(strtolower($string));

        foreach (['-', '\''] as $delimiter) {
            if (strpos($string, $delimiter) !== false) {
                $nDelimiter = is_null($newDelimiter)?  $delimiter : $newDelimiter;
                $string = implode($nDelimiter, array_map('ucfirst', explode($delimiter, $string)));
            }
        }
        return $string;
    }

    /**
     * convert test_one_two to TestOneTwo
     *
     * @param $input
     * @param string $separator
     * @return string
     */
    public static function camelize($input, $separator = '_')
    {
        return str_replace($separator, '', ucwords($input, $separator));
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public static function convertToSnakeCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * Transforma um Collection em string.
     *
     * @code
     *   StringHelper::arrayCollectionToString($collection, ',', 'codEntidade');
     * @endcode
     *
     * @param Collection $collection
     * @param string     $glue
     * @param string     $property
     *
     * @return string
     */
    public static function arrayCollectionToString(Collection $collection, $glue, $property)
    {
        $newCollection = $collection->map(function ($item) use ($property) {
            return $item->{'get' . ucfirst($property)}();
        });

        return implode($glue, $newCollection->toArray());
    }

    /**
     * Converte os valores do formulário para string
     *
     * @code
     *   StringHelper::convertAtributoDinamicoValorToString($codTipo, $valor);
     * @endcode
     *
     * @param  integer $codTipo
     * @param  mixed $valor
     * @return string
     */
    public static function convertAtributoDinamicoValorToString($codTipo, $valor)
    {
        switch ($codTipo) {
            case TipoAtributo::NUMERICO:
            case TipoAtributo::NUMERICO_2:
            case TipoAtributo::TEXTO_LONGO:
            case TipoAtributo::TEXTO:
                $valor = (string) $valor;
                break;
            case TipoAtributo::LISTA:
            case TipoAtributo::LISTA_MULTIPLA:
                // @TODO Implementar arrayCollectionToString
                break;
            case TipoAtributo::DATA:
                if ($valor != "") {
                    $valor = $valor->format('d/m/Y');
                } else {
                    $valor = (string) $valor;
                }
                break;
        }

        return $valor;
    }

    /**
     * @param $string
     * @param bool $responseToLower
     * @return mixed|string
     */
    public static function removeSpecialCharacter($string, $inputToUpper = true, $responseToLower = true)
    {
        $string = $inputToUpper ? mb_strtoupper($string) : $string;
        $from = array(
            'á','À','Á','Â','Ã','Ä','Å',
            'ß','Ç',
            'È','É','Ê','Ë',
            'Ì','Í','Î','Ï','Ñ',
            'Ò','Ó','Ô','Õ','Ö',
            'Ù','Ú','Û','Ü');

        $to = array(
            'a','A','A','A','A','A','A',
            'B','C',
            'E','E','E','E',
            'I','I','I','I','N',
            'O','O','O','O','O',
            'U','U','U','U');

        return $responseToLower ? mb_strtolower(str_replace($from, $to, $string)) : str_replace($from, $to, $string);
    }

    /**
     * Funcao que serve para transformar o numero em romano
     * @param integer $integer Recebe algum numero inteiro
     * @return string Retorna a string do numero romano
     */
    public static function convertIntegerToRoman($integer)
    {
        $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
        $return = '';
        while ($integer > 0) {
            foreach ($table as $rom => $arb) {
                if ($integer >= $arb) {
                    $integer -= $arb;
                    $return .= $rom;
                    break;
                }
            }
        }

        return $return;
    }
}
