<?php

namespace Urbem\CoreBundle\Repository\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\Modalidade;

class ModalidadeRepository extends ORM\EntityRepository
{
    /**
     * @param $key
     * @return null|object|Modalidade
     */
    public function getByKey($key)
    {
        return $this->findOneBy([
            'codModalidade' => $key,
        ]);
    }
}
