<?php
namespace Urbem\CoreBundle\Helper;

class MascaraHelper
{
    public static function parseMascara($array)
    {
        $mascara = '';
        foreach ($array as $value) {
            $mascara .= $value->getMascara() . '.';
        }
        return substr($mascara, 0, -1);
    }

    public static function parseMascaraClassificacaoPai($mascara)
    {
        $array = explode('.', $mascara);
        $length = count($array) - 1;
        $inTamPos = strlen($array[$length]);
        $array[$length] = str_pad('0', $inTamPos, 0, STR_PAD_LEFT);
        return implode('.', $array);
    }

    /**
     * Se o código for 1.4.2.1.1.02.07.00.00.00 retorna 1.4.2.1.1.02.07
     *
     * @param $estrutura
     * @param bool $removeLastDot
     * @return string
     */
    public static function reduzida($estrutura, $removeLastDot = false)
    {
        return rtrim($estrutura, '0.') . (true === $removeLastDot ? '' : '.');
    }
}
