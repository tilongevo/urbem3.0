<?php

namespace Urbem\CoreBundle\Repository\Cse;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class CidadaoRepository extends ORM\EntityRepository
{
    public function findAllCidadao()
    {
        $stmt = $this->createQueryBuilder('c')->getQuery();
        return $stmt->getResult(ORM\Query::HYDRATE_ARRAY);
    }
}
