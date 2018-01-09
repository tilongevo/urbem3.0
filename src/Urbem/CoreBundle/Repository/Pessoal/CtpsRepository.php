<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class CtpsRepository
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class CtpsRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCtpsCode()
    {
        return $this->nextVal('cod_ctps');
    }
}
