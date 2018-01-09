<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;
use Urbem\CoreBundle\Model;

class AtributoFuncaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\\AtributoFuncao");
    }

    public function getByCodFuncao($codFuncao)
    {
        $repository = $this->entityManager->getRepository("CoreBundle:Administracao\\AtributoFuncao");
        $query = $repository->createQueryBuilder('a')
                            ->where('a.codFuncao <= :codFuncao')
                            ->setParameter('codFuncao', $codFuncao);

        return $query->getQuery()->getResult();
    }
}
