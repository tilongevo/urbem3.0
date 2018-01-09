<?php

namespace Urbem\CoreBundle\Repository\Beneficio;

use Urbem\CoreBundle\Repository\AbstractRepository;

class FaixaDescontoRepository extends AbstractRepository
{
    public function getUltimaFaixaDesconto($codVigencia)
    {
        return $this->nextVal(
            'cod_faixa',
            array(
                'cod_vigencia' => $codVigencia
            )
        );
    }
}
