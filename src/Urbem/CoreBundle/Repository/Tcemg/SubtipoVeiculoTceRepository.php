<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class SubtipoVeiculoTceRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class SubtipoVeiculoTceRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function findAllToArray()
    {
        $data = $this->createQueryBuilder('t')
            ->orderBy('t.codTipoTce')
            ->getQuery()
            ->getArrayResult();

        return $data;
    }
}