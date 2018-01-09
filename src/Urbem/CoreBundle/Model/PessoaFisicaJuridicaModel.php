<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class PessoaFisicaJuridicaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:PessoaFisicaJuridicaView");
    }

    public function getPessoaFisicaJuridica(array $paramsWhere)
    {
        return $this->repository->findPessoaFisicaJuridica($paramsWhere);
    }
}
