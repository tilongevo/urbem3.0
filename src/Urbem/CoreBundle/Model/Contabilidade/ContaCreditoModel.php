<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class ContaCreditoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const TYPE_TIPO_VALOR = 'C';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\ContaCredito");
    }
}
