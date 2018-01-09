<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\FaixaDesconto;

/**
 * Class FaixaDescontoModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class FaixaDescontoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(FaixaDesconto::class);
    }

    /**
     * @param FaixaDesconto $faixaDesconto
     * @return bool
     */
    public function canRemove(FaixaDesconto $faixaDesconto)
    {
        return true;
    }

    public function getNextFaixaDescontoCode()
    {
        return $this->repository->getNextFaixaDescontoCode();
    }
}
