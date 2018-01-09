<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Doctrine\ORM\Query;
use Urbem\CoreBundle\AbstractModel;

class PensaoEventoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\PensaoEvento");
    }

    public function consultaPensaoEvento($object)
    {
        return $this->repository->consultaPensaoEvento($object);
    }

    public function deletePensaoEvento($object)
    {
        return $this->repository->deletePensaoEvento($object);
    }
}
