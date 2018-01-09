<?php

namespace Urbem\CoreBundle\Model\Beneficio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Symfony\Component\HttpFoundation\Response;

class FaixaDescontoModel
{
    private $entityManager = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Beneficio\FaixaDesconto");
    }
    
    public function getUltimaFaixaDesconto($codVigencia)
    {
        return $this->repository->getUltimaFaixaDesconto($codVigencia);
    }
}
