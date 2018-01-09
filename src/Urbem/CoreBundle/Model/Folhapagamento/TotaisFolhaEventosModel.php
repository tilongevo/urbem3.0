<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class TotaisFolhaEventosModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\TotaisFolhaEventos");
    }

    public function consultaTotaisFolhaEventos($object)
    {
        $this->repository->consultaTotaisFolhaEventos($object);
    }
}
