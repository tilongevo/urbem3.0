<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class NotaFiscalFornecedorOrdemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class NotaFiscalFornecedorOrdemModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * MapaCotacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\NotaFiscalFornecedorOrdem::class);
    }

    /**
     * @param Compras\NotaFiscalFornecedor $notaFiscalFornecedor
     * @param Compras\Ordem $ordem
     * @return Compras\NotaFiscalFornecedorOrdem
     */
    public function buildOne(Compras\NotaFiscalFornecedor $notaFiscalFornecedor, Compras\Ordem $ordem)
    {
        $notaFiscalFornecedorOrdem = $this->getOneByNotaFiscalFornecedor($notaFiscalFornecedor);

        if (true == is_null($notaFiscalFornecedorOrdem)) {
            $notaFiscalFornecedorOrdem = new Compras\NotaFiscalFornecedorOrdem();
            $notaFiscalFornecedorOrdem->setFkComprasNotaFiscalFornecedor($notaFiscalFornecedor);
            $notaFiscalFornecedorOrdem->setFkComprasOrdem($ordem);

            $this->save($notaFiscalFornecedorOrdem);
        }

        return $notaFiscalFornecedorOrdem;
    }

    /**
     * @param Compras\Ordem $ordem
     * @return null|Compras\NotaFiscalFornecedorOrdem
     */
    public function getOneByOrdem(Compras\Ordem $ordem)
    {
        return $this->repository->findOneBy([
            'fkComprasOrdem' => $ordem
        ]);
    }

    /**
     * @param Compras\NotaFiscalFornecedor $notaFiscalFornecedor
     * @return null|Compras\NotaFiscalFornecedorOrdem
     */
    public function getOneByNotaFiscalFornecedor(Compras\NotaFiscalFornecedor $notaFiscalFornecedor)
    {
        return $this->repository->findOneBy([
            'fkComprasNotaFiscalFornecedor' => $notaFiscalFornecedor
        ]);
    }
}
