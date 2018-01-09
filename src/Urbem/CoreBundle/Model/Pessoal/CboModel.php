<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class CboModel implements Model\InterfaceModel
{
    private $entityManager = null;
    private $cboRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->cboRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\Cbo");
    }

    public function getCboById($codCbo)
    {
        $return = $this->cboRepository->findOneByCodCbo($codCbo);
        return $return;
    }

    public function canRemove($object)
    {
        $cboCargoRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\CboCargo");
        $resCboCargo = $cboCargoRepository->findOneByCodCbo($object->getCodCbo());

        $cboEspecialidadeRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\CboEspecialidade");
        $resCboEspecialidade = $cboEspecialidadeRepository->findOneByCodCbo($object->getCodCbo());

        return is_null($resCboCargo) && is_null($resCboEspecialidade);
    }
}
