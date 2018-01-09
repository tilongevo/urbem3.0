<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;

class TipoEventoFgtsModel
{
    private $entityManager = null;
    private $tipoEventoFgtsRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->tipoEventoFgtsRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\TipoEventoFgts");
    }

    public function gettipoEventoFgtsByCodTipo($codTipo)
    {
        $return = $this->tipoEventoFgtsRepository->findOneByCodTipo($codTipo);
        return $return;
    }
}
