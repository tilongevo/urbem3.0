<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class AtributoContratoServidorValorModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\AtributoContratoServidorValor");
    }

    public function findByCodContrato($codContrato)
    {
        return $this->repository->findByCodContrato($codContrato);
    }
}
