<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Doctrine\ORM\Query;
use Urbem\CoreBundle\AbstractModel;

class SequenciaCalculoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\SequenciaCalculo");
    }
    
    public function deleteSequenciaCalculoEvento($object)
    {
        return $this->repository->deleteSequenciaCalculoEvento($object);
    }
    
    public function selectBasesEventoCriado($cod_base)
    {
        return $this->repository->selectBasesEventoCriado($cod_base);
    }
    
    public function isUnique(array $parameters = [])
    {
        return $this->repository->isUnique($parameters);
    }
}
