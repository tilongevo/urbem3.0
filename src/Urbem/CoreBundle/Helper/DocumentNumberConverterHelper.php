<?php
namespace Urbem\CoreBundle\Helper;

/**
 * Class DocumentNumberConverterHelper
 * @package Urbem\CoreBundle\Helper
 */
class DocumentNumberConverterHelper
{
    /**
     * Converte para a mascara de CEP
     * @param $documentNumber
     * @return string
     */
    public static function parseNumberToCep($documentNumber)
    {
        $regex = "/^(\d{5})(\d{3})$/";
        preg_match($regex, $documentNumber, $matches);

        $retorno = $documentNumber;
        if (count($matches) == 3) {
            $retorno = $matches[1]
            . "-"
            . $matches[2];
        }
        
        return $retorno;
    }

    /**
     * Converte para a mascara de CPF
     * @param $documentNumber
     * @return string
     */
    public static function parseNumberToCpf($documentNumber)
    {
        $regex = "/^(\d{3})(\d{3})(\d{3})([\d]{2})$/";
        preg_match($regex, $documentNumber, $matches);
        
        $retorno = $documentNumber;
        if (count($matches) == 5) {
            $retorno = $matches[1]
            . "."
            . $matches[2]
            . "."
            . $matches[3]
            . "-"
            . $matches[4];
        }
        
        return $retorno;
    }

    /**
     * Converte para a mascara de RG
     * @param $documentNumber
     * @return string
     */
    public static function parseNumberToRg($documentNumber)
    {
        $regex = "/^([a-zA-Z0-9]{2})(\d{3})(\d{3})([a-zA-Z0-9]{2})$/";
        preg_match($regex, $documentNumber, $matches);

        $retorno = $documentNumber;
        if (count($matches) == 5) {
            $retorno = $matches[1]
                . "."
                . $matches[2]
                . "."
                . $matches[3]
                . "-"
                . $matches[4];
        }

        return $retorno;
    }

    /**
     * Converte para a mascara de CNPJ
     * @param $documentNumber
     * @return string
     */
    public static function parseNumberToCnpj($documentNumber)
    {
        $regex = "/^(\d{2})(\d{3})(\d{3})([\d]{4})(\d{2})$/";
        preg_match($regex, $documentNumber, $matches);
        
        $retorno = $documentNumber;
        if (count($matches) == 6) {
            $retorno = $matches[1]
            . "."
            . $matches[2]
            . "."
            . $matches[3]
            . "/"
            . $matches[4]
            . "-"
            . $matches[5];
        }
        
        return $retorno;
    }
}
