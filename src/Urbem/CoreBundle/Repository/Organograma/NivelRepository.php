<?php

namespace Urbem\CoreBundle\Repository\Organograma;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class NivelRepository
 *
 * @package Urbem\CoreBundle\Repository\Organograma
 */
class NivelRepository extends AbstractRepository
{
    /**
     * @param string $codOrganograma
     *
     * @return int
     */
    public function nextCodNivel($codOrganograma)
    {
        return parent::nextVal('cod_nivel', ['cod_organograma' => $codOrganograma]);
    }
}
