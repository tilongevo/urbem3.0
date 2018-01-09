<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class TipoDecretoRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class TipoDecretoRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function findAllToArray()
    {
        $result = $this->createQueryBuilder('t')
            ->getQuery()
            ->getArrayResult();

        return $result;
    }
}