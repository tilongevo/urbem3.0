<?php
namespace Urbem\CoreBundle\Helper;

/**
 * Funções de validação de documentos encontradas no link:
 * https://forum.imasters.com.br/topic/400293-validate_br/
 *
 * Class ValidaDocumentoHelper
 * @package Urbem\CoreBundle\Helper
 */
class ValidaDocumentoHelper
{
    /**
     * Validates CNPJ (Cadastro Nacional da Pessoa Jurídica)
     *
     * CNPJ is the Brazilian corporate taxpayer identification number.
     *
     * @param   string $cnpj CNPJ number to validate
     * @return  bool TRUE if the number is a valid CNPJ, FALSE otherwise
     * @access  public
     * @since   20050619
     */
    public static function CNPJ($cnpj)
    {
        // Canonicalize input
        $cnpj = sprintf('%014s', preg_replace('{\D}', '', $cnpj));

        // Validate length and CNPJ order
        if ((strlen($cnpj) != 14)
                || (intval(substr($cnpj, -4)) == 0)) {
            return false;
        }

        // Validate check digits using a modulus 11 algorithm
        for ($t = 11; $t < 13;) {
            for ($d = 0, $p = 2, $c = $t; $c >= 0; $c--, ($p < 9) ? $p++
                                                                  : $p = 2) {
                $d += $cnpj[$c] * $p;
            }

            if ($cnpj[++$t] != ($d = ((10 * $d) % 11) % 10)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates CPF (Cadastro de Pessoas Físicas)
     *
     * CPF is the Brazilian individual taxpayer identification number.
     *
     * @param   string $cpf CPF number to validate
     * @return  bool TRUE if the number is a valid CPF, FALSE otherwise
     * @access  public
     * @since   20050617
     */
    public static function CPF($cpf)
    {
        // Canonicalize input
        $cpf = sprintf('%011s', preg_replace('{\D}', '', $cpf));

        // Validate length and invalid numbers
        if ((strlen($cpf) != 11)
                || ($cpf == '00000000000')
                || ($cpf == '99999999999')) {
            return false;
        }

        // Validate check digits using a modulus 11 algorithm
        for ($t = 8; $t < 10;) {
            for ($d = 0, $p = 2, $c = $t; $c >= 0; $c--, $p++) {
                $d += $cpf[$c] * $p;
            }

            if ($cpf[++$t] != ($d = ((10 * $d) % 11) % 10)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates NIS (PIS/PASEP/NIT)
     *
     * PIS/PASEP/NIT is the Brazilian social integration program.
     *
     * @param   string $nis NIS number to validate
     * @return  bool TRUE if the number is a valid NIS, FALSE otherwise
     * @access  public
     * @since   20050620
     */
    public static function NIS($nis)
    {
        // Canonicalize input
        $nis = sprintf('%011s', preg_replace('{\D}', '', $nis));

        // Validate length and invalid numbers
        if ((strlen($nis) != 11)
                || (intval($nis) == 0)) {
            return false;
        }

        // Validate check digit using a modulus 11 algorithm
        for ($d = 0, $p = 2, $c = 9; $c >= 0; $c--, ($p < 9) ? $p++ : $p = 2) {
            $d += $nis[$c] * $p;
        }

        return ($nis[10] == (((10 * $d) % 11) % 10));
    }
}
