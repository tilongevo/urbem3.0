<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

class ConfiguracaoEmpenhoLlaLotacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\ConfiguracaoEmpenhoLlaLotacao");
    }

    public function updateCodConfiguracaoLla($configuracaoEmpenhoLla, $object)
    {
        $this->repository->updateCodConfiguracaoLla($configuracaoEmpenhoLla, $object);
    }
}
