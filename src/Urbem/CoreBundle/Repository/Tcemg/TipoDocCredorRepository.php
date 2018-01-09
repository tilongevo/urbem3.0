<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class TipoDocCredorRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class TipoDocCredorRepository extends AbstractRepository
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