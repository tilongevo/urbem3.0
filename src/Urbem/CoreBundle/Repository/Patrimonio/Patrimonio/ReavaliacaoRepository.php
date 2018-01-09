<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ReavaliacaoRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio
 */
class ReavaliacaoRepository extends AbstractRepository
{
    /**
     * @param $codBem
     * @return int
     */
    public function getProximoCodReavaliacao($codBem)
    {
        return $this->nextVal('cod_reavaliacao', ['cod_bem' => $codBem]);
    }
}
