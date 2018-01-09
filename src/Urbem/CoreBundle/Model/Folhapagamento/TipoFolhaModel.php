<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM\EntityManager;

class TipoFolhaModel
{
    private $entityManager = null;
    private $repository = null;

    /**
     * TipoFolhaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\TipoFolha");
    }
}
