<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class SwClassificacaoModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:SwClassificacao');
    }

    public function canRemove($object)
    {
        $swAssuntoRepository = $this->entityManager->getRepository("CoreBundle:SwAssunto");
        $result = $swAssuntoRepository->findOneByCodClassificacao($object->getCodClassificacao());

        return is_null($result);
    }

}
