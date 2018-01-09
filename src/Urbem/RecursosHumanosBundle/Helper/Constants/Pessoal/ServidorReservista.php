<?php

namespace Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal;

/**
 * Class ServidorReservista
 * @package Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal
 */
abstract class ServidorReservista
{
    const CATRESERVISTA = [
        'naoInformado' => '0',
        '1a' => '1',
        '2a' => '2',
        '3a' => '3'
    ];

    const ORIGEMRESERVISTA = [
        'naoInformado' => '0',
        'exercito' => '1',
        'marinha' => '2',
        'aeronautica' => '3'
    ];
}
