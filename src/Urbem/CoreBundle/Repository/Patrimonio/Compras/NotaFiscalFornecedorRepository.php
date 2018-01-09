<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class NotaFiscalFornecedorRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio\Compras
 */
class NotaFiscalFornecedorRepository extends AbstractRepository
{
    /**
     * @param int $cgmFornecedor
     * @return int
     */
    public function nextCodNota($cgmFornecedor)
    {
        return parent::nextVal('cod_nota', ['cgm_fornecedor' => $cgmFornecedor]);
    }
}
