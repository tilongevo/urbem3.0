<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class SindicatoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\Sindicato");
    }

    public function canRemove($object)
    {
        $sindicatoFuncaoRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\SindicatoFuncao");
        $res = $sindicatoFuncaoRepository->findOneBy(['numcgm' => $object->getNumCgm()]);

        return is_null($res);
    }
}
