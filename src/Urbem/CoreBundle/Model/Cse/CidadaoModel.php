<?php

namespace Urbem\CoreBundle\Model\Cse;

use EasyTaxi\CorporateBundle\Model;
use EasyTaxi\CorporateBundle\Document;
use EasyTaxi\CorporateBundle\Repository;
use Doctrine\ORM;

class CidadaoModel
{
    private $entityManager = null;
    private $cidadaoRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->cidadaoRepository = $this->entityManager->getRepository("CoreBundle:Cse\\Cidadao");
    }

    public function getAllCidadao()
    {
        return $this->cidadaoRepository->findAllCidadao();
    }
}
