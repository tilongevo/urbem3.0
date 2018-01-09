<?php

namespace Urbem\CoreBundle\Model\Beneficio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class VigenciaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Beneficio\Vigencia");
    }

    public function isVigenciaExists($dataVigencia, $tipoVigencia)
    {
        return $this->repository->getVigenciaRepetida($dataVigencia, $tipoVigencia);
    }
}
