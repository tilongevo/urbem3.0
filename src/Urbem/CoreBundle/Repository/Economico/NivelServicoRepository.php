<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class NivelServicoRepository
 * @package Urbem\CoreBundle\Repository\Economico
 */
class NivelServicoRepository extends AbstractRepository
{
    /**
     * @param $codVigencia
     * @return int
     */
    public function nextCodNivelServico()
    {
        return parent::nextVal('cod_nivel');
    }
}
