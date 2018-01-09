<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ProdutoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getProximoCodProduto()
    {
        return $this->nextVal("cod_produto");
    }
}
