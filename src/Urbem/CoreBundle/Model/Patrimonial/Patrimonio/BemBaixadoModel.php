<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class BemBaixadoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\BemBaixado");
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    public function getBensDisponiveis()
    {
        $bemBaixadoRepository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\BemBaixado");

        return $bemBaixadoRepository->getBensDisponiveis();
    }
}
