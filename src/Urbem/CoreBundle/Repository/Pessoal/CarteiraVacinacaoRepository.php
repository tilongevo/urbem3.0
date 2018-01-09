<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class CarteiraVacinacaoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodCarteira()
    {
        return $this->nextVal('cod_carteira');
    }
}
