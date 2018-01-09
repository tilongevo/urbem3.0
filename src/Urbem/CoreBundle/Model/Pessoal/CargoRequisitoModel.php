<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;

class CargoRequisitoModel
{
    private $entityManager = null;
    private $cargoRequisitoRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->cargoRequisitoRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\CargoRequisito");
    }

    public function getCargoRequisitoById($codCargo)
    {
        $return = $this->cargoRequisitoRepository->findByCodCargo($codCargo);

        return $return;
    }
}
