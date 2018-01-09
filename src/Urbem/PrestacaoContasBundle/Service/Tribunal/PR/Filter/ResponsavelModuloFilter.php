<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter;

use Urbem\CoreBundle\Entity\Tcepr\TipoModulo;

final class ResponsavelModuloFilter
{
    /**
     * @var TipoModulo
     */
    protected $fkTceprTipoModulo;

    /**
     * @return TipoModulo
     */
    public function getFkTceprTipoModulo()
    {
        return $this->fkTceprTipoModulo;
    }

    /**
     * @param TipoModulo $fkTceprTipoModulo
     */
    public function setFkTceprTipoModulo($fkTceprTipoModulo)
    {
        $this->fkTceprTipoModulo = $fkTceprTipoModulo;
    }
}