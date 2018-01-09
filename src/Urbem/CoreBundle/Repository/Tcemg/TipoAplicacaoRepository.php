<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class TipoAplicacaoRepository
 * @package Urbem\CoreBundle\Repository\Tcemg */
class TipoAplicacaoRepository extends AbstractRepository
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