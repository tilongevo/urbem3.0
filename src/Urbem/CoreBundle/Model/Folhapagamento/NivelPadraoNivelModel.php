<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class NivelPadraoNivelModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\NivelPadraoNivel");
    }

    public function getUltimoNivelPadraoNivel($codPadrao)
    {
        return $this->repository->getUltimoNivelPadraoNivel($codPadrao);
    }
}
