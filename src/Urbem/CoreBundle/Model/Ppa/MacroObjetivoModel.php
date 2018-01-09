<?php

namespace Urbem\CoreBundle\Model\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class MacroObjetivoModel extends AbstractModel implements Model\InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ppa\MacroObjetivo");
    }

    public function canRemove($object)
    {
        $excluirMacro = $this->entityManager->getRepository("CoreBundle:Ppa\ProgramaSetorial")
        ->findByCodMacro($object->getCodMacro());

        $isToRemove = true;
        if (count($excluirMacro) > 0) {
            $isToRemove = false;
        }

        return $isToRemove;
    }
}
