<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model\InterfaceModel;

class ConselhoModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\Conselho");
    }

    public function canRemove($object)
    {
        $contratoServidorConselhoRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\ContratoServidorConselho");

        return empty($contratoServidorConselhoRepository->findOneByCodConselho($object->getCodConselho()));
    }
}
