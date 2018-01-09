<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;

class CboCargoModel
{
    private $entityManager = null;
    private $cboCargoRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->cboCargoRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\CboCargo");
    }

    public function getCboCargoByCodCargo($codCargo)
    {
        $return = $this->cboCargoRepository->findOneByCodCargo($codCargo);
        return $return;
    }

    public function getCboCargoByCodCargoCodCbo($codCargo, $codCbo)
    {
        $return = $this->cboCargoRepository->findOneBy(
            array('codCargo' => $codCargo, 'codCbo' => $codCbo)
        );
        return $return;
    }
}
