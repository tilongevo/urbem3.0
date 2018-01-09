<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class NivelPadraoNivelRepository extends AbstractRepository
{
    public function getUltimoNivelPadraoNivel($codPadrao)
    {
        return $this->nextVal(
            "cod_nivel_padrao",
            array(
                'cod_padrao' => $codPadrao
            )
        );
    }
}
