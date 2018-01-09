<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ValoresIdentificadoresRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class ValoresIdentificadoresRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function findAllToArray()
    {
        $result = $this->createQueryBuilder('v')
            ->getQuery()
            ->getArrayResult();

        return $result;
    }
}
