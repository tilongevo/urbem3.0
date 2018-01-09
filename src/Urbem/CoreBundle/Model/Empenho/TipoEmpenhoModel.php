<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class TipoEmpenhoModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Empenho\TipoEmpenho");
    }

    public function getOneTipoEmpenho($codTipo)
    {
        return $this->repository->findOneBy([
            'codTipo' => $codTipo
        ]);
    }
}
