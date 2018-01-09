<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;

class DiasTurnoModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\DiasTurno");
    }

    public function getDiasDaSemana()
    {
        return $this->repository->findDiasDaSemana();
    }
}
