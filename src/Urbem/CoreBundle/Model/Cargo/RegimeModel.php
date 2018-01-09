<?php

namespace Urbem\CoreBundle\Model\Cargo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model\InterfaceModel;

class RegimeModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\ConfiguracaoEmpenhoSubdivisao");
    }

    public function canRemove($object)
    {
        $modeloRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\ContratoServidor");
        $res = $modeloRepository->findOneByCodRegime($object->getCodRegime());

        $configuracaoFormaPagamentoFerias = $this->entityManager->getRepository("CoreBundle:Pessoal\ConfiguracaoFormaPagamentoFerias");
        $resFormaPagamentoFerias = $configuracaoFormaPagamentoFerias->findOneByCodRegime($object->getCodRegime());

        return is_null($res) && is_null($resFormaPagamentoFerias);
    }
}
