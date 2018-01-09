<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Pessoal;

class RegimeModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\Regime");
    }

    public function getListaRegimeSubdivisaoFuncaoEspecialidade()
    {
        return $this->repository->getListaRegimeSubdivisaoFuncaoEspecialidade();
    }
}
