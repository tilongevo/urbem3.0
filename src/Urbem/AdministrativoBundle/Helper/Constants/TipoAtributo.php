<?php

namespace Urbem\AdministrativoBundle\Helper\Constants;

/**
 * Class TipoAtributo
 *
 * @package Urbem\AdministrativoBundle\Helper\Constants
 */
class TipoAtributo
{
    const NUMERICO = 1;
    const TEXTO = 2;
    const LISTA = 3;
    const LISTA_MULTIPLA = 4;
    const DATA = 5;
    const NUMERICO_2 = 6; // Decimal, ex.: 2,50, 2.50
    const TEXTO_LONGO = 7;

    /**
     * src/Urbem/AdministrativoBundle/Controller/Administracao/AtributoDinamicoAdminController.php
     *
     * @param $codTipo
     * @return string
     */
    public static function getNomeAtributo($codTipo)
    {
        $name = '';

        switch ((int) $codTipo) {
            case self::NUMERICO:
                $name = 'atributoDinamicoNumero';
                break;
            case self::TEXTO:
                $name = 'atributoDinamicoTexto';
                break;
            case self::LISTA:
                $name = 'atributoDinamicoLista';
                break;
            case self::LISTA_MULTIPLA:
                $name = 'atributoDinamicoListaMultipla';
                break;
            case self::DATA:
                $name = 'atributoDinamicoData';
                break;
            case self::NUMERICO_2:
                $name = 'atributoDinamicoDecimal';
                break;
            case self::TEXTO_LONGO:
                $name = 'atributoDinamicoTextoLongo';
                break;
        }

        return $name;
    }
}
