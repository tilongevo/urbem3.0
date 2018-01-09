<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class ContaDebitoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const TYPE_TIPO_VALOR = 'D';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\ContaDebito");
    }
}
