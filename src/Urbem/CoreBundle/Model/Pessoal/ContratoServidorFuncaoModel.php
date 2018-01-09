<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ContratoServidorFuncaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\ContratoServidorFuncao");
    }

    public function findOneByCodContrato($codContrato)
    {
        return $this->repository->findOneByCodContrato($codContrato);
    }

    public function consulta($codContrato)
    {
        return $this->repository->consulta($codContrato);
    }
}
