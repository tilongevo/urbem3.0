<?php

namespace Urbem\CoreBundle\Twig;

use Urbem\CoreBundle\Helper\DocumentNumberConverterHelper;

/**
 * Class NumberConverterExtension
 *
 * @package Urbem\CoreBundle\Twig
 */
class NumberConverterExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array (
            new \Twig_SimpleFilter('cep', [$this, 'numberToCep']),
            new \Twig_SimpleFilter('cpf', [$this, 'numberToCpf']),
            new \Twig_SimpleFilter('cnpj', [$this, 'numberToCnpj']),
            new \Twig_SimpleFilter('rg', [$this, 'numberToRg'])
        );
    }

    /**
     * Formata número para CEP
     *
     * @param int|string $number
     *
     * @return string
     */
    public function numberToCep($number)
    {
        return DocumentNumberConverterHelper::parseNumberToCep($number);
    }

    /**
     * Formata número para CPF
     *
     * @param int|string $number
     *
     * @return string
     */
    public function numberToCpf($number)
    {
        return DocumentNumberConverterHelper::parseNumberToCpf($number);
    }

    /**
     * Formata número para CNPJ
     *
     * @param int|string $number
     *
     * @return string
     */
    public function numberToCnpj($number)
    {
        return DocumentNumberConverterHelper::parseNumberToCnpj($number);
    }

    /**
     * Formata número para RG
     *
     * @param int|string $number
     *
     * @return string
     */
    public function numberToRg($number)
    {
        return DocumentNumberConverterHelper::parseNumberToRg($number);
    }
}
