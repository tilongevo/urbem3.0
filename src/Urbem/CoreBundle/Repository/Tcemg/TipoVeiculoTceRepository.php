<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class TipoVeiculoTceRepository
 * @package Urbem\CoreBundle\Repository\Frota
 */
class TipoVeiculoTceRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function findAllToArray()
    {
        $data = $this->createQueryBuilder('t')
            ->getQuery()
            ->getArrayResult();

        return $data;
    }
}